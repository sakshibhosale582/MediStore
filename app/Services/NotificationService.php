<?php

namespace App\Services;

use App\Models\NotificationModel;

class NotificationService
{
    protected NotificationModel $notificationModel;

    public function __construct()
    {
        $this->notificationModel = model(NotificationModel::class);
    }

    public function create(int $userId, string $title, string $message, string $type = 'info', ?string $link = null): int
    {
        return (int) $this->notificationModel->insert([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'type'    => $type,
            'link'    => $link,
            'is_read' => 0,
        ]);
    }

    public function notifyOrderPlaced(int $userId, int $orderId, string $orderNumber): int
    {
        return $this->create(
            $userId,
            'Order Placed',
            "Your order #{$orderNumber} has been placed successfully.",
            'order',
            "/customer/orders/{$orderId}"
        );
    }

    public function notifyOrderStatus(int $userId, int $orderId, string $status, string $orderNumber): int
    {
        $statusLabels = [
            'placed'                => 'placed',
            'prescription_verified' => 'prescription verified',
            'payment_confirmed'     => 'payment confirmed',
            'packed'                => 'packed',
            'shipped'               => 'shipped',
            'out_for_delivery'      => 'out for delivery',
            'delivered'             => 'delivered',
            'cancelled'             => 'cancelled',
            'return_requested'      => 'return requested',
        ];

        $label = $statusLabels[$status] ?? str_replace('_', ' ', $status);

        return $this->create(
            $userId,
            'Order Update',
            "Your order #{$orderNumber} is now {$label}.",
            'order',
            "/customer/orders/{$orderId}"
        );
    }

    public function notifyReturnRequested(int $userId, int $orderId, string $orderNumber): int
    {
        return $this->create(
            $userId,
            'Return Requested',
            "Your return request for order #{$orderNumber} has been submitted.",
            'return',
            "/customer/orders/{$orderId}"
        );
    }

    public function notifyPrescriptionStatus(int $userId, int $prescriptionId, string $status): int
    {
        return $this->create(
            $userId,
            'Prescription Update',
            "Your prescription has been {$status}.",
            'prescription',
            "/customer/prescriptions/{$prescriptionId}"
        );
    }

    public function markAsRead(int $notificationId, int $userId): bool
    {
        return $this->notificationModel->markAsRead($notificationId, $userId);
    }

    public function markAllAsRead(int $userId): bool
    {
        return $this->notificationModel->markAllAsRead($userId);
    }

    public function getUnreadCount(int $userId): int
    {
        return $this->notificationModel->getUnreadCount($userId);
    }

    public function getRecent(int $userId, int $limit = 10): array
    {
        return $this->notificationModel->getByUser($userId, $limit);
    }
}
