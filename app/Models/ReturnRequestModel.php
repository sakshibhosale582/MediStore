<?php

namespace App\Models;

use CodeIgniter\Model;

class ReturnRequestModel extends Model
{
    protected $table            = 'return_requests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['order_id', 'user_id', 'reason', 'status', 'refund_status', 'admin_notes'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function hasPendingReturn(int $orderId): bool
    {
        return (bool) $this->where('order_id', $orderId)->whereIn('status', ['pending', 'approved'])->countAllResults();
    }
}
