<?php
session_start();
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
$mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : 'all';

if ($id > 0 && isset($_SESSION['cart'])) {
    if ($mode === 'one') {
        $key = array_search($id, $_SESSION['cart']);
        if ($key !== false) unset($_SESSION['cart'][$key]);
    } else {
        $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($v) => $v != $id);
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}
// Скрипт просто отрабатывает, JS сам обновит страницу
exit;