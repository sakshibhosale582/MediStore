<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table            = 'order_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['order_id', 'medicine_id', 'medicine_name', 'quantity', 'price', 'total'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    public function getByOrderId(int $orderId): array
    {
        return $this->where('order_id', $orderId)->findAll();
    }
}
