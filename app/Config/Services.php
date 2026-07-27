<?php

namespace Config;

use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    public static function cartService(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('cartService');
        }
        return new \App\Services\CartService();
    }

    public static function orderService(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('orderService');
        }
        return new \App\Services\OrderService();
    }

    public static function notificationService(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('notificationService');
        }
        return new \App\Services\NotificationService();
    }

    public static function pdfService(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('pdfService');
        }
        return new \App\Libraries\PdfGenerator();
    }
}
