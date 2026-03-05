<?php include 'db.php'; ?>

<form method="POST" action="process_order.php">
    Телефон: <input type="text" name="tel"><br>
    Дата доставки: <input type="date" name="date"><br>
    Время: <input type="text" name="time"><br>

    <button type="submit">Подтвердить заказ</button>
</form>
