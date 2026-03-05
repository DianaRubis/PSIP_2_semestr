<?php
// db.php
$host = 'localhost';
$db   = 'mydb';
$user = 'root';
$pass = ''; // или 'root' в зависимости от настроек OSPanel
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$conn = new mysqli($host, $user, $pass, $db);

try {
    // Переменная ДОЛЖНА называться $pdo
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
?>