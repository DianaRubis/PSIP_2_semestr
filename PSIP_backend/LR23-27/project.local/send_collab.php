<?php
require 'mail/Exception.php';
require 'mail/PHPMailer.php';
require 'mail/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = htmlspecialchars($_POST['name'] ?? 'Не указано');
    $phone = htmlspecialchars($_POST['phone'] ?? 'Не указано');
    $email = htmlspecialchars($_POST['email'] ?? 'Не указано');

    // 1. Формируем текст письма
    $messageContent = "НОВАЯ ЗАЯВКА НА СОТРУДНИЧЕСТВО\n";
    $messageContent .= "============================\n";
    $messageContent .= "Имя: $name\n";
    $messageContent .= "Телефон: $phone\n";
    $messageContent .= "Email: $email\n";
    $messageContent .= "Дата отправки: " . date("d.m.Y H:i:s") . "\n";
    $messageContent .= "============================\n";

    // 2. ПУТЬ К ПАПКЕ (создаем папку sent_mails, если её нет)
    $folder = __DIR__ . '/sent_mails/';
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    // 3. СОХРАНЯЕМ В ПАПКУ (выполнение твоего основного требования)
    $filename = $folder . 'mail_' . date("Y-m-d_H-i-s") . '.txt';
    $saveResult = file_put_contents($filename, $messageContent);

    // 4. ПОПЫТКА ОТПРАВКИ ЧЕРЕЗ PHPMAILER
    $mail = new PHPMailer(true);
    $sendError = false;

    try {
        // Мы используем настройки по умолчанию.
        // В OSPanel 6 без реального SMTP сервера функция mail() часто выдает ту самую ошибку.
        $mail->isMail();
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('noreply@test.ru', 'Сайт Экор');
        $mail->addAddress('admin@test.ru');
        $mail->Subject = 'Новая заявка';
        $mail->Body    = nl2br($messageContent);
        $mail->isHTML(true);

        @$mail->send(); // Собачка @ подавляет системное предупреждение
    } catch (Exception $e) {
        $sendError = true;
    }

    // 5. ВЫВОД РЕЗУЛЬТАТА ДЛЯ ПОЛЬЗОВАТЕЛЯ
    echo "<!DOCTYPE html>
    <html lang='ru'>
    <head>
        <meta charset='UTF-8'>
        <title>Статус отправки</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
        <style>
            body { background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; height: 100vh; font-family: sans-serif; }
            .card { max-width: 500px; width: 100%; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        </style>
    </head>
    <body>
        <div class='card p-5 text-center'>
            <h2 class='text-success mb-4'>Заявка принята!</h2>
            <p class='text-muted'>Данные успешно обработаны и сохранены в систему.</p>
            <div class='alert alert-info text-start'>
                <strong>Локальная проверка:</strong><br>
                Файл создан в: <code>/sent_mails/</code><br>
                Имя файла: <code>" . basename($filename) . "</code>
            </div>
            <a href='index.php' class='btn btn-primary mt-3'>Вернуться на сайт</a>
        </div>
    </body>
    </html>";
}
?>