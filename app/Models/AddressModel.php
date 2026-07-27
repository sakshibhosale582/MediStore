<?php

namespace App\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{
    protected $table            = 'addresses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id', 'label', 'name', 'phone', 'address_line',
        'city', 'state', 'pincode', 'is_default',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'user_id'      => 'required|integer',
        'name'         => 'required|min_length[2]|max_length[100]',
        'phone'        => 'required|min_length[10]|max_length[20]',
        'address_line' => 'required',
        'city'         => 'required|max_length[100]',
        'state'        => 'required|max_length[100]',
        'pincode'      => 'required|min_length[6]|max_length[10]',
    ];

    public function getByUser(int $userId): array
    {
        return $this->where('user_id', $userId)
            ->orderBy('is_default', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function getUserAddress(int $userId, int $addressId): ?array
    {
        return $this->where('user_id', $userId)->where('id', $addressId)->first();
    }

    public function getDefault(int $userId): ?array
    {
        return $this->where('user_id', $userId)->where('is_default', 1)->first();
    }

    public function setDefault(int $userId, int $addressId): bool
    {
        $this->where('user_id', $userId)->set(['is_default' => 0])->update();

        return $this->update($addressId, ['is_default' => 1]);
    }
}
