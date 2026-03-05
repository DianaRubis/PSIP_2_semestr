<?php
session_start();
echo "<h3>Проверка сессии:</h3>";
if(isset($_SESSION['user_status'])) {
    echo "Вы вошли как: " . $_SESSION['user_status'];
} else {
    echo "Сессия пуста.";
}
?>