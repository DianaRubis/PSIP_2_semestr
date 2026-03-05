<?php
session_start();
require_once 'db.php';

// Проверка прав доступа (админ должен быть авторизован)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

/** @var PDO $pdo */

// Получаем данные для всех разделов
$users = $pdo->query("SELECT * FROM users")->fetchAll();
$products = $pdo->query("SELECT p.*, pt.name as cat_name FROM products p LEFT JOIN product_type pt ON p.type_id = pt.id_product_type")->fetchAll();
$categories = $pdo->query("SELECT * FROM product_type")->fetchAll();
$delivers = $pdo->query("SELECT * FROM delivers")->fetchAll();

// ЗАПРОС ДЛЯ ЗАКАЗОВ (Новое!)
$orders = $pdo->query("
    SELECT o.*, u.login as user_login 
    FROM orders o 
    LEFT JOIN users u ON o.user_id = u.id_users 
    ORDER BY o.id_order DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель администратора</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .admin-header { background: #343a40; color: white; padding: 20px 0; margin-bottom: 30px; }
        .tab-content { background: white; padding: 20px; border: 1px solid #dee2e6; border-top: none; border-radius: 0 0 5px 5px; }
        .table img { max-width: 50px; height: auto; border-radius: 4px; }
    </style>
</head>
<body>

<div class="admin-header">
    <div class="container d-flex justify-content-between align-items-center">
        <h1>Управление магазином</h1>
        <a href="index.php" class="btn btn-outline-light">На сайт</a>
    </div>
</div>

<div class="container">
    <ul class="nav nav-tabs" id="adminTabs">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-products">Товары</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-categories">Категории</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-orders">Заказы</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-users">Пользователи</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-delivers">Доставка</button></li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane fade show active" id="tab-products">
            <div class="d-flex justify-content-between mb-3">
                <h4>Список товаров</h4>
            </div>
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Фото</th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Цена</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($products as $p): ?>
                    <tr>
                        <td><?= $p['id_products'] ?></td>
                        <td><img src="img/products/<?= $p['img'] ?>" alt=""></td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= htmlspecialchars($p['cat_name']) ?></td>
                        <td><?= $p['price'] ?> руб.</td>
                        <td>
                            <a href="admin_actions.php?action=delete_product&id=<?= $p['id_products'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Удалить товар?')">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <h5 class="mt-4">Добавить новый товар</h5>
            <form action="admin_actions.php" method="POST" enctype="multipart/form-data" class="row g-2 p-3 bg-light border rounded">
                <input type="hidden" name="action" value="add_product">

                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Название товара" required>
                </div>

                <div class="col-md-2">
                    <input type="number" name="price" class="form-control" placeholder="Цена" required>
                </div>

                <div class="col-md-2">
                    <select name="type_id" class="form-select">
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id_product_type'] ?>"><?= $cat['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="file" name="img_file" class="form-control" accept="image/*" required>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Добавить</button>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="tab-categories">
            <h4>Категории товаров</h4>
            <table class="table table-sm">
                <thead><tr><th>ID</th><th>Название</th><th>Действия</th></tr></thead>
                <tbody>
                <?php foreach($categories as $cat): ?>
                    <tr>
                        <td><?= $cat['id_product_type'] ?></td>
                        <td><?= htmlspecialchars($cat['name']) ?></td>
                        <td>
                            <a href="admin_actions.php?action=delete_category&id=<?= $cat['id_product_type'] ?>" class="btn btn-danger btn-sm">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <form action="admin_actions.php" method="POST" class="row g-2 mt-3">
                <input type="hidden" name="action" value="add_category">
                <div class="col-md-10"><input type="text" name="name" class="form-control" placeholder="Новая категория" required></div>
                <div class="col-md-2"><button type="submit" class="btn btn-success w-100">Создать</button></div>
            </form>
        </div>

        <div class="tab-pane fade" id="tab-orders">
            <h4>Управление заказами</h4>
            <table class="table table-hover table-sm">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Клиент</th>
                    <th>Товары</th>
                    <th>Сумма</th>
                    <th>Дата</th>
                    <th>Телефон</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($orders as $o): ?>
                    <tr>
                        <td><?= $o['id_order'] ?></td>
                        <td><?= htmlspecialchars($o['user_login'] ?? 'Гость') ?></td>
                        <td><small><?= htmlspecialchars($o['product_id']) ?></small></td>
                        <td><strong><?= $o['summa'] ?> руб.</strong></td>
                        <td><?= $o['date'] ?></td>
                        <td><?= htmlspecialchars($o['tel']) ?></td>
                        <td>
                            <a href="admin_actions.php?action=delete_order&id=<?= $o['id_order'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Удалить запись о заказе?')">❌</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="tab-users">
            <h4>Зарегистрированные пользователи</h4>
            <table class="table table-striped">
                <thead><tr><th>ID</th><th>Логин</th><th>Email</th><th>Действия</th></tr></thead>
                <tbody>
                <?php foreach($users as $u): ?>
                    <tr>
                        <td><?= $u['id_users'] ?></td>
                        <td><?= htmlspecialchars($u['login']) ?></td>
                        <td><?= htmlspecialchars($u['e_mail']) ?></td>
                        <td>
                            <a href="admin_actions.php?action=delete_user&id=<?= $u['id_users'] ?>" class="btn btn-danger btn-sm">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="tab-delivers">
            <h4>Курьеры / Доставка</h4>
            <table class="table table-hover">
                <thead><tr><th>ID</th><th>ФИО</th><th>Инфо</th><th>Действия</th></tr></thead>
                <tbody>
                <?php foreach($delivers as $d): ?>
                    <tr>
                        <td><?= $d['id_delivers'] ?></td>
                        <td><?= htmlspecialchars($d['lastname'] . " " . $d['firstname']) ?></td>
                        <td><?= htmlspecialchars($d['information']) ?></td>
                        <td>
                            <a href="admin_actions.php?action=delete_deliver&id=<?= $d['id_delivers'] ?>" class="btn btn-danger btn-sm">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <form action="admin_actions.php" method="POST" class="row g-2 mt-3 p-3 bg-light border rounded">
                <input type="hidden" name="action" value="add_deliver">
                <div class="col-md-3"><input type="text" name="lastname" class="form-control" placeholder="Фамилия" required></div>
                <div class="col-md-3"><input type="text" name="firstname" class="form-control" placeholder="Имя" required></div>
                <div class="col-md-4"><input type="text" name="info" class="form-control" placeholder="Информация"></div>
                <div class="col-md-2"><button type="submit" class="btn btn-success w-100">Добавить</button></div>
            </form>
        </div>

    </div>
</div>








<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>