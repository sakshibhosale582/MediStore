<?php

namespace App\Services;

use App\Models\AddressModel;
use App\Models\CouponModel;
use App\Models\MedicineModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\OrderTrackingModel;
use App\Models\ReturnRequestModel;

class OrderService
{
    protected CartService $cartService;

    protected NotificationService $notificationService;

    protected OrderModel $orderModel;

    protected OrderItemModel $orderItemModel;

    protected OrderTrackingModel $trackingModel;

    protected AddressModel $addressModel;

    protected MedicineModel $medicineModel;

    protected CouponModel $couponModel;

    protected ReturnRequestModel $returnModel;

    public function __construct()
    {
        $this->cartService           = service('cartService');
        $this->notificationService   = service('notificationService');
        $this->orderModel            = model(OrderModel::class);
        $this->orderItemModel        = model(OrderItemModel::class);
        $this->trackingModel         = model(OrderTrackingModel::class);
        $this->addressModel          = model(AddressModel::class);
        $this->medicineModel         = model(MedicineModel::class);
        $this->couponModel           = model(CouponModel::class);
        $this->returnModel           = model(ReturnRequestModel::class);
    }

    public function placeOrder(int $userId, int $addressId, string $paymentMethod = 'cod', ?string $notes = null): array
    {
        if ($this->cartService->isEmpty()) {
            return ['success' => false, 'message' => 'Your cart is empty.'];
        }

        $address = $this->addressModel->getUserAddress($userId, $addressId);

        if (! $address) {
            return ['success' => false, 'message' => 'Invalid shipping address.'];
        }

        $summary = $this->cartService->getSummary();
        $items   = $summary['items'];

        foreach ($items as $item) {
            $medicine = $this->medicineModel->find($item['medicine_id']);
            if (! $medicine || (int) $medicine['stock'] < (int) $item['quantity']) {
                return ['success' => false, 'message' => 'Insufficient stock for ' . $item['name'] . '.'];
            }
        }

        $db = db_connect();
        $db->transStart();

        $shippingAddress = implode(', ', array_filter([
            $address['address_line'],
            $address['city'],
            $address['state'],
            $address['pincode'],
        ]));

        $coupon = $this->cartService->getCoupon();

        $orderData = [
            'order_number'    => $this->orderModel->generateOrderNumber(),
            'user_id'         => $userId,
            'address_id'      => $addressId,
            'shipping_name'   => $address['name'],
            'shipping_phone'  => $address['phone'],
            'shipping_address'=> $shippingAddress,
            'subtotal'        => $summary['subtotal'],
            'tax'             => $summary['tax'],
            'delivery_charge' => $summary['delivery_charge'],
            'discount'        => $summary['discount'],
            'coupon_id'       => $coupon['id'] ?? null,
            'grand_total'     => $summary['grand_total'],
            'payment_method'  => $paymentMethod,
            'payment_status'  => $paymentMethod === 'online' ? 'pending' : 'pending',
            'order_status'    => 'placed',
            'notes'           => $notes,
        ];

        $orderId = $this->orderModel->insert($orderData);

        if (! $orderId) {
            $db->transRollback();

            return ['success' => false, 'message' => 'Failed to create order.'];
        }

        foreach ($items as $item) {
            $lineTotal = round((float) $item['price'] * (int) $item['quantity'], 2);

            $this->orderItemModel->insert([
                'order_id'      => $orderId,
                'medicine_id'   => $item['medicine_id'],
                'medicine_name' => $item['name'],
                'quantity'      => $item['quantity'],
                'price'         => $item['price'],
                'total'         => $lineTotal,
            ]);

            $this->medicineModel->decrementStock($item['medicine_id'], (int) $item['quantity']);
        }

        if ($coupon) {
            $this->couponModel->incrementUsage((int) $coupon['id']);
        }

        $this->trackingModel->addTracking((int) $orderId, 'placed', 'Order placed successfully.');

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['success' => false, 'message' => 'Failed to process order. Please try again.'];
        }

        $this->cartService->clear();

        $order = $this->orderModel->find($orderId);

        $this->notificationService->notifyOrderPlaced($userId, (int) $orderId, $order['order_number']);

        return [
            'success'      => true,
            'message'      => 'Order placed successfully.',
            'order_id'     => (int) $orderId,
            'order_number' => $order['order_number'],
        ];
    }

    public function getTracking(int $orderId, ?int $userId = null): ?array
    {
        $order = $this->orderModel->getWithItems($orderId);

        if (! $order) {
            return null;
        }

        if ($userId !== null && (int) $order['user_id'] !== $userId) {
            return null;
        }

        $order['tracking'] = $this->trackingModel->getByOrderId($orderId);

        return $order;
    }

    public function cancelOrder(int $orderId, int $userId, ?string $reason = null): array
    {
        $order = $this->orderModel->find($orderId);

        if (! $order || (int) $order['user_id'] !== $userId) {
            return ['success' => false, 'message' => 'Order not found.'];
        }

        $cancellable = ['placed', 'prescription_verified', 'payment_confirmed'];

        if (! in_array($order['order_status'], $cancellable, true)) {
            return ['success' => false, 'message' => 'This order cannot be cancelled at its current status.'];
        }

        $db = db_connect();
        $db->transStart();

        $this->orderModel->updateStatus($orderId, 'cancelled');

        $items = $this->orderItemModel->getByOrderId($orderId);
        foreach ($items as $item) {
            $this->medicineModel->incrementStock((int) $item['medicine_id'], (int) $item['quantity']);
        }

        $note = $reason ? 'Order cancelled: ' . $reason : 'Order cancelled by customer.';
        $this->trackingModel->addTracking($orderId, 'cancelled', $note);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['success' => false, 'message' => 'Failed to cancel order.'];
        }

        $this->notificationService->notifyOrderStatus($userId, $orderId, 'cancelled', $order['order_number']);

        return ['success' => true, 'message' => 'Order cancelled successfully.'];
    }

    public function requestReturn(int $orderId, int $userId, string $reason): array
    {
        $order = $this->orderModel->find($orderId);

        if (! $order || (int) $order['user_id'] !== $userId) {
            return ['success' => false, 'message' => 'Order not found.'];
        }

        if ($order['order_status'] !== 'delivered') {
            return ['success' => false, 'message' => 'Only delivered orders can be returned.'];
        }

        if ($this->returnModel->hasPendingReturn($orderId)) {
            return ['success' => false, 'message' => 'A return request already exists for this order.'];
        }

        $returnId = $this->returnModel->insert([
            'order_id'      => $orderId,
            'user_id'       => $userId,
            'reason'        => $reason,
            'status'        => 'pending',
            'refund_status' => 'none',
        ]);

        if (! $returnId) {
            return ['success' => false, 'message' => 'Failed to submit return request.'];
        }

        $this->orderModel->updateStatus($orderId, 'return_requested');
        $this->trackingModel->addTracking($orderId, 'return_requested', 'Return requested: ' . $reason);

        $this->notificationService->notifyReturnRequested($userId, $orderId, $order['order_number']);

        return ['success' => true, 'message' => 'Return request submitted successfully.', 'return_id' => (int) $returnId];
    }

    public function updateOrderStatus(int $orderId, string $status, ?string $notes = null): array
    {
        $order = $this->orderModel->find($orderId);

        if (! $order) {
            return ['success' => false, 'message' => 'Order not found.'];
        }

        $this->orderModel->updateStatus($orderId, $status);
        $this->trackingModel->addTracking($orderId, $status, $notes);

        $this->notificationService->notifyOrderStatus(
            (int) $order['user_id'],
            $orderId,
            $status,
            $order['order_number']
        );

        return ['success' => true, 'message' => 'Order status updated.'];
    }
}
