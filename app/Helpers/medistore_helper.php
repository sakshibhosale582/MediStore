<?php

if (!function_exists('format_price')) {
    function format_price($amount): string
    {
        return "\u{20B9}" . number_format((float) $amount, 2);
    }
}

if (!function_exists('slugify')) {
    function slugify(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        return $text ?: 'item-' . time();
    }
}

if (!function_exists('order_status_badge')) {
    function order_status_badge(string $status): string
    {
        $map = ['placed' => 'primary', 'prescription_verified' => 'info', 'payment_confirmed' => 'success', 'packed' => 'warning', 'shipped' => 'info', 'out_for_delivery' => 'primary', 'delivered' => 'success', 'cancelled' => 'danger', 'return_requested' => 'secondary'];
        $color = $map[$status] ?? 'secondary';
        return '<span class="badge bg-' . esc($color) . '">' . esc(ucwords(str_replace('_', ' ', $status))) . '</span>';
    }
}

if (!function_exists('prescription_status_badge')) {
    function prescription_status_badge(string $status): string
    {
        $map = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'];
        return '<span class="badge bg-' . esc($map[$status] ?? 'secondary') . '">' . esc(ucfirst($status)) . '</span>';
    }
}

if (!function_exists('medicine_price')) {
    function medicine_price(object|array $medicine): float
    {
        $m = (array) $medicine;
        return !empty($m['discount_price']) && $m['discount_price'] > 0 ? (float) $m['discount_price'] : (float) $m['price'];
    }
}

if (!function_exists('upload_url')) {
    function upload_url(?string $path, string $default = ''): string
    {
        $placeholder = $default ?: 'assets/img/placeholder-medicine.png';
        $path = trim((string) $path);
        if ($path === '') {
            return base_url($placeholder);
        }
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }
        $path = ltrim(str_replace('\\', '/', $path), '/');
        if (str_starts_with($path, 'assets/')) {
            return base_url($path);
        }
        if (!str_starts_with($path, 'uploads/')) {
            $path = 'uploads/' . $path;
        }
        return base_url($path);
    }
}
