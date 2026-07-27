<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table            = 'notifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'title', 'message', 'type', 'link', 'is_read'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function markAsRead(int $notificationId, int $userId): bool
    {
        return $this->where('id', $notificationId)->where('user_id', $userId)->set(['is_read' => 1])->update();
    }

    public function markAllAsRead(int $userId): bool
    {
        return $this->where('user_id', $userId)->set(['is_read' => 1])->update();
    }

    public function getUnreadCount(int $userId): int
    {
        return (int) $this->where('user_id', $userId)->where('is_read', 0)->countAllResults();
    }

    public function getByUser(int $userId, int $limit = 10): array
    {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC')->limit($limit)->findAll();
    }
}
