<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'email', 'password', 'phone', 'role', 'avatar',
        'email_verified', 'verification_token', 'reset_token', 'reset_expires',
        'remember_token', 'is_active',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name'     => 'required|min_length[2]|max_length[100]',
        'email'    => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'permit_empty|min_length[6]',
        'role'     => 'in_list[customer,pharmacist,admin]',
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password']) && $data['data']['password'] !== '') {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['password']);
        }

        return $data;
    }

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function findByVerificationToken(string $token): ?array
    {
        return $this->where('verification_token', $token)->first();
    }

    public function findByResetToken(string $token): ?array
    {
        return $this->where('reset_token', $token)
            ->where('reset_expires >=', date('Y-m-d H:i:s'))
            ->first();
    }

    public function getByRole(string $role): array
    {
        return $this->where('role', $role)->where('is_active', 1)->findAll();
    }

    public function getActiveCustomers(): array
    {
        return $this->getByRole('customer');
    }
}
