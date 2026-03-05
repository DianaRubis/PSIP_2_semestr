<h2>5. Пользовательская функция</h2>

<?php
function calc($x)
{
    if ($x >= 7) {
        return -pow($x, 2);
    } else {
        if ($x * $x - 9 == 0) {
            return "Ошибка: деление на ноль";
        }
        return pow(2, -$x) / ($x * $x - 9);
    }
}

$values = [2, 3, 7, 8];

foreach ($values as $x) {
    echo "x = $x → f(x) = " . calc($x) . "<br>";
}
?>
