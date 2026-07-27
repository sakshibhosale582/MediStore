<?php

namespace App\Models;

use CodeIgniter\Model;

class CouponModel extends Model
{
    protected $table            = 'coupons';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['code', 'type', 'value', 'min_order', 'max_uses', 'used_count', 'starts_at', 'expires_at', 'status'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function validateCoupon(string $code, float $subtotal): ?array
    {
        $now = date('Y-m-d H:i:s');

        $coupon = $this->where('code', strtoupper(trim($code)))
            ->where('status', 1)
            ->where('starts_at <=', $now)
            ->where('expires_at >=', $now)
            ->first();

        if (! $coupon) {
            return null;
        }

        if ((float) $coupon['min_order'] > $subtotal) {
            return null;
        }

        if (! empty($coupon['max_uses']) && (int) $coupon['used_count'] >= (int) $coupon['max_uses']) {
            return null;
        }

        return $coupon;
    }

    public function calculateDiscount(array $coupon, float $subtotal): float
    {
        if ($coupon['type'] === 'percent') {
            return round(min($subtotal, ((float) $coupon['value'] / 100) * $subtotal), 2);
        }

        return round(min((float) $coupon['value'], $subtotal), 2);
    }

    public function incrementUsage(int $couponId): bool
    {
        return $this->db->table($this->table)
            ->where('id', $couponId)
            ->set('used_count', 'used_count + 1', false)
            ->update();
    }
}
