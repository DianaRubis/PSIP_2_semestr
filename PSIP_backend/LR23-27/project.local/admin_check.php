<?php
// admin_check.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Проверяем роль, установленную в auth.php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>