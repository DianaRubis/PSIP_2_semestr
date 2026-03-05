<?php
// Устанавливаем куки на 1 час (3600 секунд)
setcookie("site_theme", "dark", time() + 3600, "/");

echo "<h3>Cookie установлена!</h3>";
if(isset($_COOKIE['site_theme'])) {
    echo "Текущая тема из Cookie: " . $_COOKIE['site_theme'];
} else {
    echo "Обновите страницу, чтобы увидеть Cookie.";
}
?>