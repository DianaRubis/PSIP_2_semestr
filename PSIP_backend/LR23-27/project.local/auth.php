<?php
// Сначала запускаем сессию
session_start();
require 'db.php';

$login = isset($_POST['login']) ? $_POST['login'] : '';
$pass = isset($_POST['password']) ? $_POST['password'] : '';

if (empty($login) || empty($pass)) {
    header("Location: index.php?error=empty");
    exit;
}

/** @var PDO $pdo */
$stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
$stmt->execute([$login]);
$user = $stmt->fetch();

if ($user && $user['password'] == $pass) {
    $_SESSION['user_id'] = $user['id_users'];
    $_SESSION['login'] = $user['login'];

    $checkAdmin = $pdo->prepare("SELECT * FROM admin WHERE user_id = ?");
    $checkAdmin->execute([$user['id_users']]);

    if ($checkAdmin->fetch()) {
        $_SESSION['role'] = 'admin';
        header("Location: admin_panel.php");
    } else {
        header("Location: index.php");
    }
    exit; // Важно добавить exit после редиректа
} else {
    // Вместо echo лучше тоже сделать редирект с ошибкой
    header("Location: index.php?error=wrong_pass");
    exit;
}
?>