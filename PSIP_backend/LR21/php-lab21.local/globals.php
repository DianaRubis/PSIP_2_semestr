<?php
echo "Имя файла: " . __FILE__ . "<br>";
echo "Номер строки: " . __LINE__ . "<br>";
echo "Версия PHP: " . PHP_VERSION . "<br><br>";

echo "Имя сервера: " . $_SERVER['SERVER_NAME'] . "<br>";
echo "Скрипт: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "Метод запроса: " . $_SERVER['REQUEST_METHOD'] . "<br>";
