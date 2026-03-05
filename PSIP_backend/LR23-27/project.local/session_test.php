<?php
// 1. Всегда начинаем с session_start()
session_start();

// 2. Записываем данные в сессию
$_SESSION['user_status'] = "Администратор";
$_SESSION['visit_time'] = date("H:i:s");

echo "<h3>Данные сохранены в сессию!</h3>";
echo "<p>Ваш статус: " . $_SESSION['user_status'] . "</p>";
echo "<a href='session_check.php'>Перейти на другую страницу, чтобы проверить</a>";
?>