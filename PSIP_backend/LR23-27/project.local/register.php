<?php
// 1. Сначала сессия (БЕЗ пробелов перед <?php)
session_start();
require_once 'db.php';

// Проверяем, что данные пришли через POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastname  = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $surname   = isset($_POST['surname']) ? $_POST['surname'] : '';
    $email     = isset($_POST['e_mail']) ? $_POST['e_mail'] : '';
    $login     = isset($_POST['login']) ? $_POST['login'] : '';
    $pass      = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($login) || empty($pass)) {
        die("Ошибка: Логин и пароль обязательны!");
    }

    /** @var PDO $pdo */
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    // Проверка, не занят ли логин
    $check = $pdo->prepare("SELECT id_users FROM users WHERE login = ?");
    $check->execute(array($login));
    if ($check->fetch()) {
        die("Ошибка: Этот логин уже занят!");
    }

    // Вставляем данные в твою таблицу
    // id_users обычно инкрементируется сам, поэтому его не пишем
    $sql = "INSERT INTO users (lastname, firstname, surname, login, password, e_mail) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    $result = $stmt->execute(array($lastname, $firstname, $surname, $login, $pass, $email));

    if ($result) {
        // Сразу логиним пользователя после регистрации
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['login'] = $login;
        header("Location: index.php");
        exit;
    } else {
        echo "Ошибка при записи в базу данных!";
    }
} else {
    header("Location: index.php");
    exit;
}
?>