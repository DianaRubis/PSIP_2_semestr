<?php
session_start();
if (!isset($_SESSION['last_order'])) {
    header("Location: index.php");
    exit;
}
$order = $_SESSION['last_order'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Чек заказа №<?= $order['id'] ?></title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f0f0; padding: 20px; }
        .receipt {
            background: #fff; max-width: 600px; margin: 0 auto; padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1); border-top: 8px solid #0d6efd;
        }
        .header { text-align: center; margin-bottom: 30px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px dashed #eee; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; border-bottom: 2px solid #333; padding: 10px 5px; }
        td { padding: 10px 5px; border-bottom: 1px solid #eee; }
        .total { text-align: right; font-size: 22px; font-weight: bold; margin-top: 25px; color: #0d6efd; }
        .no-print-area { text-align: center; margin-bottom: 20px; }
        .btn {
            padding: 10px 25px; cursor: pointer; border-radius: 5px; border: none;
            font-weight: bold; text-decoration: none; display: inline-block;
        }
        .btn-print { background: #198754; color: #fff; }
        .btn-back { background: #6c757d; color: #fff; margin-left: 10px; }

        /* Правила для печати */
        @media print {
            .no-print-area { display: none; }
            body { background: #fff; padding: 0; }
            .receipt { box-shadow: none; border: none; max-width: 100%; width: 100%; }
        }
    </style>
</head>
<body>

<div class="no-print-area">
    <button onclick="window.print()" class="btn btn-print">🖨️ Распечатать или Сохранить в PDF</button>
    <a href="index.php" class="btn btn-back">Вернуться в магазин</a>
</div>

<div class="receipt">
    <div class="header">
        <h1 style="margin:0; color:#0d6efd;">FISH SHOP</h1>
        <p style="margin:5px 0; color:#666;">Магазин свежих морепродуктов</p>
        <h3 style="margin-top:20px;">ТОВАРНЫЙ ЧЕК №<?= $order['id'] ?></h3>
    </div>

    <div class="info-row"><span>Дата:</span> <strong><?= $order['date'] ?></strong></div>
    <div class="info-row"><span>Телефон клиента:</span> <strong><?= htmlspecialchars($order['tel']) ?></strong></div>
    <div class="info-row"><span>Комментарий:</span> <strong><?= htmlspecialchars($order['info']) ?></strong></div>

    <table>
        <thead>
        <tr>
            <th>Наименование</th>
            <th style="text-align:center;">Кол-во</th>
            <th style="text-align:right;">Сумма</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($order['items'] as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td style="text-align:center;"><?= $item['qty'] ?></td>
                <td style="text-align:right;"><?= number_format($item['total'], 2) ?> BYN</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total">
        ИТОГО: <?= number_format($order['total'], 2) ?> BYN
    </div>

    <div style="margin-top:50px; text-align:center; font-size:12px; color:#aaa;">
        <p>Спасибо за выбор нашего магазина!<br>Данный документ подтверждает факт совершения заказа.</p>
    </div>
</div>

</body>
</html>