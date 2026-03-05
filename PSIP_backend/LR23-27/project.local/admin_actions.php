<?php
session_start();
require_once 'db.php';

// Проверка прав доступа
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Доступ запрещен");
}

/** @var PDO $pdo */

// 1. УДАЛЕНИЕ (GET запросы)
if (isset($_GET['action'])) {
    $id = $_GET['id'] ?? null;

    switch ($_GET['action']) {
        case 'delete_product':
            // Опционально: здесь можно добавить код удаления самого файла с диска
            $stmt = $pdo->prepare("DELETE FROM products WHERE id_products = ?");
            $stmt->execute([$id]);
            break;
        case 'delete_user':
            $stmt = $pdo->prepare("DELETE FROM users WHERE id_users = ?");
            $stmt->execute([$id]);
            break;
        case 'delete_category':
            $stmt = $pdo->prepare("DELETE FROM product_type WHERE id_product_type = ?");
            $stmt->execute([$id]);
            break;
        case 'delete_order':
            $stmt = $pdo->prepare("DELETE FROM orders WHERE id_order = ?");
            $stmt->execute([$id]);
            break;
    }
    header("Location: admin_panel.php");
    exit;
}

// 2. ДОБАВЛЕНИЕ (POST запросы)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add_product':
            $name = $_POST['name'];
            $price = $_POST['price'];
            $type_id = $_POST['type_id'];
            $img_db_path = 'default.jpg'; // Заглушка по умолчанию

            // Обработка загрузки файла
            if (isset($_FILES['img_file']) && $_FILES['img_file']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = 'img/products/';

                // Создаем директорию, если она отсутствует
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $extension = pathinfo($_FILES['img_file']['name'], PATHINFO_EXTENSION);
                $new_filename = time() . '_' . uniqid() . '.' . $extension;
                $target_path = $upload_dir . $new_filename;

                if (move_uploaded_file($_FILES['img_file']['tmp_name'], $target_path)) {
                    // Сохраняем путь в формате 'products/имя_файла.jpg'
                    // чтобы в админке путь img/products/... работал корректно
                    $img_db_path = $new_filename;
                }
            }

            // В вашей БД shop_id обязателен, ставим 1
            $stmt = $pdo->prepare("INSERT INTO products (name, price, type_id, shop_id, img) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $price, $type_id, 1, $img_db_path]);
            break;

        case 'add_category':
            $stmt = $pdo->prepare("INSERT INTO product_type (name) VALUES (?)");
            $stmt->execute([$_POST['name']]);
            break;

        case 'add_deliver':
            $stmt = $pdo->prepare("INSERT INTO delivers (lastname, firstname, information) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['lastname'], $_POST['firstname'], $_POST['info']]);
            break;
    }
    header("Location: admin_panel.php");
    exit;
}