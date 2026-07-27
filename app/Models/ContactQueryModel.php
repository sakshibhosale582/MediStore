<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactQueryModel extends Model
{
    protected $table            = 'contact_queries';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'email', 'message', 'status'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
