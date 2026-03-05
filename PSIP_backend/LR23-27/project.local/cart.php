<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<div class='container mt-5 text-center'><h2>Корзина пуста 🐟</h2><a href='index.php' class='btn btn-primary'>В магазин</a></div>";
    exit;
}
/** @var PDO $pdo */
$item_counts = array_count_values($_SESSION['cart']);
$ids = array_keys($item_counts);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT * FROM products WHERE id_products IN ($placeholders)");
$stmt->execute($ids);
$products = $stmt->fetchAll();

$total_sum = 0;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .qty-btn { width: 35px; height: 35px; border-radius: 50%; font-weight: bold; }
        .product-card { transition: 0.3s; border-radius: 15px; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="fw-bold mb-4">Ваш заказ</h2>
    <div class="row">
        <div class="col-lg-8">
            <?php foreach ($products as $p):
                $id = $p['id_products'];
                $qty = $item_counts[$id];
                $subtotal = $p['price'] * $qty;
                $total_sum += $subtotal;
                ?>
                <div class="card mb-3 shadow-sm border-0 product-card" id="product-row-<?= $id ?>">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="img/products/<?= $p['img'] ?>" style="width: 60px; height: 60px; object-fit: cover;" class="rounded me-3">
                            <div>
                                <h6 class="mb-0 fw-bold"><?= htmlspecialchars($p['name']) ?></h6>
                                <small class="text-muted"><?= $p['price'] ?> BYN</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <button onclick="changeQty(<?= $id ?>, 'minus')" class="btn btn-outline-secondary qty-btn" id="minus-<?= $id ?>" <?= ($qty <= 1) ? 'disabled' : '' ?>>-</button>
                            <span class="mx-3 fw-bold fs-5" id="qty-val-<?= $id ?>"><?= $qty ?></span>
                            <button onclick="changeQty(<?= $id ?>, 'plus')" class="btn btn-outline-secondary qty-btn">+</button>
                        </div>

                        <div class="text-end" style="min-width: 100px;">
                            <span class="fw-bold text-primary" id="subtotal-<?= $id ?>"><?= number_format($subtotal, 2) ?> BYN</span>
                        </div>

                        <button onclick="changeQty(<?= $id ?>, 'delete')" class="btn btn-link text-danger ms-2">🗑️</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="col-lg-4">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 20px;">
                <h4 class="fw-bold mb-4">Итого: <span id="total-sum"><?= number_format($total_sum, 2) ?></span> BYN</h4>
                <form action="process_order.php" method="POST">
                    <div class="mb-3">
                        <label class="small fw-bold">ТЕЛЕФОН</label>
                        <input type="tel" name="tel" class="form-control" placeholder="+375..." required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">ДАТА ДОСТАВКИ</label>
                        <input type="date" name="date" class="form-control" required min="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">КОММЕНТАРИЙ К ЗАКАЗУ</label>
                        <textarea name="information" class="form-control" rows="2" placeholder="Дополнительные детали..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-3 fw-bold">ОФОРМИТЬ ЗАКАЗ</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function changeQty(productId, mode) {
        let url = (mode === 'plus') ? 'add_to_cart.php?id=' : 'remove_from_cart.php?id=';

        // Для удаления отправляем специальный флаг mode=all
        let fetchUrl = url + productId;
        if (mode === 'delete') fetchUrl = 'remove_from_cart.php?id=' + productId + '&mode=all';
        if (mode === 'minus') fetchUrl += '&mode=one';

        fetch(fetchUrl, { method: 'POST' })
            .then(() => {
                // Просто перезагружаем страницу, чтобы все цифры и quanitity пересчитались верно
                location.reload();
            });
    }
</script>
</body>
</html>