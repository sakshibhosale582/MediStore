<?php

namespace App\Services;

use App\Models\CouponModel;
use App\Models\MedicineModel;

class CartService
{
    protected const SESSION_KEY = 'cart';

    protected $session;

    protected MedicineModel $medicineModel;

    protected CouponModel $couponModel;

    public function __construct()
    {
        $this->session       = service('session');
        $this->medicineModel = model(MedicineModel::class);
        $this->couponModel   = model(CouponModel::class);
    }

    public function add(int $medicineId, int $quantity = 1): array
    {
        $medicine = $this->medicineModel->find($medicineId);

        if (! $medicine || (int) $medicine['status'] !== 1) {
            return ['success' => false, 'message' => 'Medicine not found or unavailable.'];
        }

        if ((int) $medicine['stock'] < 1) {
            return ['success' => false, 'message' => 'Medicine is out of stock.'];
        }

        $cart     = $this->getCartData();
        $quantity = max(1, $quantity);

        if (isset($cart['items'][$medicineId])) {
            $newQty = $cart['items'][$medicineId]['quantity'] + $quantity;
        } else {
            $newQty = $quantity;
        }

        if ($newQty > (int) $medicine['stock']) {
            return ['success' => false, 'message' => 'Insufficient stock available.'];
        }

        $price = $this->medicineModel->getEffectivePrice($medicine);

        $cart['items'][$medicineId] = [
            'medicine_id'   => $medicineId,
            'name'          => $medicine['name'],
            'slug'          => $medicine['slug'],
            'image'         => $medicine['image'],
            'price'         => $price,
            'quantity'      => $newQty,
            'stock'         => (int) $medicine['stock'],
            'prescription_required' => (int) $medicine['prescription_required'],
        ];

        $this->saveCart($cart);

        return ['success' => true, 'message' => 'Item added to cart.', 'count' => $this->getCount()];
    }

    public function remove(int $medicineId): array
    {
        $cart = $this->getCartData();

        if (! isset($cart['items'][$medicineId])) {
            return ['success' => false, 'message' => 'Item not found in cart.'];
        }

        unset($cart['items'][$medicineId]);
        $this->saveCart($cart);

        return ['success' => true, 'message' => 'Item removed from cart.', 'count' => $this->getCount()];
    }

    public function update(int $medicineId, int $quantity): array
    {
        $cart = $this->getCartData();

        if (! isset($cart['items'][$medicineId])) {
            return ['success' => false, 'message' => 'Item not found in cart.'];
        }

        if ($quantity < 1) {
            return $this->remove($medicineId);
        }

        $medicine = $this->medicineModel->find($medicineId);

        if (! $medicine || $quantity > (int) $medicine['stock']) {
            return ['success' => false, 'message' => 'Insufficient stock available.'];
        }

        $cart['items'][$medicineId]['quantity'] = $quantity;
        $cart['items'][$medicineId]['price']    = $this->medicineModel->getEffectivePrice($medicine);

        $this->saveCart($cart);

        return ['success' => true, 'message' => 'Cart updated.', 'count' => $this->getCount()];
    }

    public function clear(): void
    {
        $this->session->remove(self::SESSION_KEY);
    }

    public function getItems(): array
    {
        return array_values($this->getCartData()['items']);
    }

    public function getCount(): int
    {
        $count = 0;
        foreach ($this->getCartData()['items'] as $item) {
            $count += (int) $item['quantity'];
        }

        return $count;
    }

    public function isEmpty(): bool
    {
        return empty($this->getCartData()['items']);
    }

    public function hasPrescriptionItems(): bool
    {
        foreach ($this->getCartData()['items'] as $item) {
            if (! empty($item['prescription_required'])) {
                return true;
            }
        }

        return false;
    }

    public function getSubtotal(): float
    {
        $subtotal = 0.0;
        foreach ($this->getCartData()['items'] as $item) {
            $subtotal += (float) $item['price'] * (int) $item['quantity'];
        }

        return round($subtotal, 2);
    }

    public function applyCoupon(string $code): array
    {
        $subtotal = $this->getSubtotal();

        if ($subtotal <= 0) {
            return ['success' => false, 'message' => 'Cart is empty.'];
        }

        $coupon = $this->couponModel->validateCoupon($code, $subtotal);

        if (! $coupon) {
            return ['success' => false, 'message' => 'Invalid or expired coupon code.'];
        }

        $cart               = $this->getCartData();
        $cart['coupon']     = [
            'id'    => $coupon['id'],
            'code'  => $coupon['code'],
            'type'  => $coupon['type'],
            'value' => (float) $coupon['value'],
        ];
        $cart['discount']   = $this->couponModel->calculateDiscount($coupon, $subtotal);

        $this->saveCart($cart);

        return ['success' => true, 'message' => 'Coupon applied successfully.', 'discount' => $cart['discount']];
    }

    public function removeCoupon(): void
    {
        $cart = $this->getCartData();
        unset($cart['coupon'], $cart['discount']);
        $this->saveCart($cart);
    }

    public function getDiscount(): float
    {
        $cart = $this->getCartData();

        return round((float) ($cart['discount'] ?? 0), 2);
    }

    public function getTax(): float
    {
        $taxable = max(0, $this->getSubtotal() - $this->getDiscount());

        return round($taxable * (TAX_RATE / 100), 2);
    }

    public function getDeliveryCharge(): float
    {
        $subtotal = $this->getSubtotal() - $this->getDiscount();

        if ($subtotal >= FREE_DELIVERY_MIN || $subtotal <= 0) {
            return 0.0;
        }

        return (float) DELIVERY_CHARGE;
    }

    public function getGrandTotal(): float
    {
        return round(
            $this->getSubtotal() - $this->getDiscount() + $this->getTax() + $this->getDeliveryCharge(),
            2
        );
    }

    public function getCoupon(): ?array
    {
        return $this->getCartData()['coupon'] ?? null;
    }

    public function getSummary(): array
    {
        return [
            'items'           => $this->getItems(),
            'count'           => $this->getCount(),
            'subtotal'        => $this->getSubtotal(),
            'discount'        => $this->getDiscount(),
            'tax'             => $this->getTax(),
            'delivery_charge' => $this->getDeliveryCharge(),
            'grand_total'     => $this->getGrandTotal(),
            'coupon'          => $this->getCoupon(),
            'has_prescription'=> $this->hasPrescriptionItems(),
        ];
    }

    protected function getCartData(): array
    {
        $cart = $this->session->get(self::SESSION_KEY);

        if (! is_array($cart)) {
            $cart = ['items' => []];
        }

        if (! isset($cart['items']) || ! is_array($cart['items'])) {
            $cart['items'] = [];
        }

        return $cart;
    }

    protected function saveCart(array $cart): void
    {
        $this->session->set(self::SESSION_KEY, $cart);
    }
}
