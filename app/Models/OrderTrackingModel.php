<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderTrackingModel extends Model
{
    protected $table            = 'order_tracking';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['order_id', 'status', 'notes'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function addTracking(int $orderId, string $status, ?string $notes = null): bool
    {
        return (bool) $this->insert([
            'order_id' => $orderId,
            'status'   => $status,
            'notes'    => $notes,
        ]);
    }

    public function getByOrderId(int $orderId): array
    {
        return $this->where('order_id', $orderId)->orderBy('created_at', 'ASC')->findAll();
    }
}
