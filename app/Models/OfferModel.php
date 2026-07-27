<?php

namespace App\Models;

use CodeIgniter\Model;

class OfferModel extends Model
{
    protected $table            = 'offers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'description', 'image', 'discount_percent', 'starts_at', 'expires_at', 'status'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getActive(): array
    {
        return $this->where('status', 1)
            ->where('expires_at >=', date('Y-m-d H:i:s'))
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
}
