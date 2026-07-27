<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice <?= esc($order['order_number']) ?></title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #212529; }
        .header { overflow: hidden; margin-bottom: 20px; border-bottom: 2px solid #198754; padding-bottom: 10px; }
        .header h1 { float: left; margin: 0; color: #198754; font-size: 22px; }
        .header .meta { float: right; text-align: right; font-size: 12px; }
        .clear { clear: both; }
        .addresses { width: 100%; margin-bottom: 20px; }
        .addresses td { width: 50%; vertical-align: top; padding: 0; }
        .addresses h3 { font-size: 13px; margin: 0 0 4px; color: #495057; }
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.items th, table.items td { border: 1px solid #dee2e6; padding: 6px 8px; text-align: left; }
        table.items th { background: #f8f9fa; }
        table.items td.num, table.items th.num { text-align: right; }
        table.summary { width: 40%; margin-left: 60%; border-collapse: collapse; }
        table.summary td { padding: 4px 8px; }
        table.summary tr.total td { border-top: 2px solid #198754; font-weight: bold; font-size: 14px; }
        .footer { margin-top: 30px; font-size: 10px; color: #6c757d; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>MediStore</h1>
        <div class="meta">
            <strong>Invoice #<?= esc($order['order_number']) ?></strong><br>
            Date: <?= esc(date('M d, Y', strtotime($order['created_at']))) ?><br>
            Payment: <?= esc(ucfirst($order['payment_method'] ?? '')) ?> (<?= esc(ucfirst($order['payment_status'] ?? '')) ?>)
        </div>
    </div>
    <div class="clear"></div>

    <table class="addresses">
        <tr>
            <td>
                <h3>Shipping To</h3>
                <?= esc($order['shipping_name'] ?? '') ?><br>
                <?= esc($order['shipping_address'] ?? '') ?><br>
                <?= esc($order['shipping_phone'] ?? '') ?>
            </td>
            <td>
                <h3>Order Status</h3>
                <?= esc(ucwords(str_replace('_', ' ', $order['order_status'] ?? ''))) ?>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Item</th>
                <th class="num">Qty</th>
                <th class="num">Price</th>
                <th class="num">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= esc($item['medicine_name']) ?></td>
                    <td class="num"><?= (int) $item['quantity'] ?></td>
                    <td class="num"><?= format_price($item['price']) ?></td>
                    <td class="num"><?= format_price($item['total']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="summary">
        <tr><td>Subtotal</td><td class="num"><?= format_price($order['subtotal']) ?></td></tr>
        <tr><td>Tax</td><td class="num"><?= format_price($order['tax']) ?></td></tr>
        <tr><td>Delivery</td><td class="num"><?= format_price($order['delivery_charge']) ?></td></tr>
        <tr><td>Discount</td><td class="num">-<?= format_price($order['discount']) ?></td></tr>
        <tr class="total"><td>Grand Total</td><td class="num"><?= format_price($order['grand_total']) ?></td></tr>
    </table>

    <div class="footer">
        Thank you for shopping with MediStore. This is a computer-generated invoice.
    </div>
</body>
</html>
