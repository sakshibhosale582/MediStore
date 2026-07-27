<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table            = 'reviews';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'medicine_id', 'order_id', 'rating', 'comment', 'status'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getByMedicine(int $medicineId): array
    {
        return $this->select('reviews.*, users.name as user_name')
            ->join('users', 'users.id = reviews.user_id', 'left')
            ->where('reviews.medicine_id', $medicineId)
            ->where('reviews.status', 'approved')
            ->orderBy('reviews.created_at', 'DESC')
            ->findAll();
    }
}
