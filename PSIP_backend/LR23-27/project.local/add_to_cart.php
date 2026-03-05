<?php
session_start();

// Получаем ID товара из ссылки
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Создаем корзину, если её нет
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Просто добавляем ID товара в массив (1 единица)
    $_SESSION['cart'][] = $id;

    echo "success";
} else {
    echo "error";
}
exit;