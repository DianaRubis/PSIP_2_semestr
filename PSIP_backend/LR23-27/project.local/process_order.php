<?php
session_start();
require_once 'db.php';

// 1. Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    die("Ошибка: Чтобы оформить заказ, необходимо войти в аккаунт.");
}

// 2. Проверка корзины
if (empty($_SESSION['cart'])) {
    die("Ошибка: Ваша корзина пуста.");
}

$user_id = $_SESSION['user_id'];
$tel = $_POST['tel'] ?? 'не указан';
$delivery_date = $_POST['date'] ?? date("Y-m-d");
$delivery_time = $_POST['time'] ?? '10:00-18:00';
$info = $_POST['information'] ?? 'Нет комментария';

try {
    /** @var PDO $pdo */
    $pdo->beginTransaction();

    // 3. Подробная обработка товаров для чека
    $total_sum = 0;
    $total_quantity = count($_SESSION['cart']);
    $shop_id = 1;

    $item_counts = array_count_values($_SESSION['cart']);
    $receipt_items = []; // Массив для красивого вывода в чек
    $product_display_names = [];

    foreach ($item_counts as $id => $quantity) {
        $stmt = $pdo->prepare("SELECT name, price FROM products WHERE id_products = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch();

        if ($product) {
            $item_total = $product['price'] * $quantity;
            $total_sum += $item_total;

            // Данные для PDF-чека
            $receipt_items[] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'qty' => $quantity,
                'total' => $item_total
            ];

            $product_display_names[] = $product['name'] . " (" . $quantity . " шт.)";
        }
    }

    $all_products_string = implode(", ", $product_display_names);

    // 4. Выбор доставщика
    $stmtC = $pdo->query("SELECT id_delivers FROM delivers");
    $courier_ids = $stmtC->fetchAll(PDO::FETCH_COLUMN);
    if (empty($courier_ids)) throw new Exception("Нет доступных доставщиков.");
    $random_courier_id = $courier_ids[array_rand($courier_ids)];

    // 5. Запись в таблицу orders (используем ваше поле quanitity)
    $sqlOrder = "INSERT INTO orders (shop_id, product_id, user_id, deliver_id, date, quanitity, tel, summa) 
                 VALUES (?, ?, ?, ?, CURDATE(), ?, ?, ?)";
    $stmtOrder = $pdo->prepare($sqlOrder);
    $stmtOrder->execute([$shop_id, $all_products_string, $user_id, $random_courier_id, $total_quantity, $tel, $total_sum]);

    $new_order_id = $pdo->lastInsertId();

    // 6. Обновление инфо доставщика
    $stmtUpdate = $pdo->prepare("UPDATE delivers SET order_id = ?, time = ?, date = ?, information = ? WHERE id_delivers = ?");
    $stmtUpdate->execute([$new_order_id, $delivery_time, $delivery_date, $info, $random_courier_id]);

    $pdo->commit();

    // --- ПОДГОТОВКА ДАННЫХ ДЛЯ ПЕЧАТИ ---
    $_SESSION['last_order'] = [
        'id' => $new_order_id,
        'date' => date("d.m.Y H:i"),
        'items' => $receipt_items,
        'total' => $total_sum,
        'tel' => $tel,
        'info' => $info
    ];

    $_SESSION['cart'] = []; // Очистка корзины

    // Перенаправляем на страницу чека
    header("Location: receipt_print.php");
    exit;

} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    die("Критическая ошибка: " . $e->getMessage());
}