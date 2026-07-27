<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['order_number', 'user_id', 'address_id', 'shipping_name', 'shipping_phone', 'shipping_address', 'subtotal', 'tax', 'delivery_charge', 'discount', 'coupon_id', 'grand_total', 'payment_method', 'payment_status', 'order_status', 'notes'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'MEDI-' . date('Ymd') . '-' . random_int(100000, 999999);
        } while ($this->where('order_number', $orderNumber)->countAllResults() > 0);

        return $orderNumber;
    }

    public function getByUserWithItems(?int $userId, int $limit = 10): array
    {
        if ($userId === null) {
            return [];
        }

        $orders = $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();

        foreach ($orders as &$order) {
            $order['items'] = model(OrderItemModel::class)->getByOrderId((int) $order['id']);
        }

        return $orders;
    }

    public function getWithItems(int $orderId): ?array
    {
        $order = $this->find($orderId);
        if (! $order) {
            return null;
        }

        $order['items'] = model(OrderItemModel::class)->getByOrderId($orderId);

        return $order;
    }

    public function updateStatus(int $orderId, string $status): bool
    {
        return $this->update($orderId, ['order_status' => $status]);
    }
}
