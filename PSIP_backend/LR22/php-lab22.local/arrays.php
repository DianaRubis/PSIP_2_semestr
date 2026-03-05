<h2>3. Массивы</h2>

<?php
$array = [5, -3, 7, -2, 10, -1, 4];
$product = 1;

foreach ($array as $value) {
    if ($value < 0) {
        $product *= $value;
    }
}

echo "Исходный массив: ";
print_r($array);
echo "<br>";

echo "Произведение отрицательных элементов: $product<br>";

for ($i = 0; $i < count($array); $i++) {
    if ($array[$i] < 0) {
        $array[$i] = 100;
    }
}

echo "Изменённый массив: ";
print_r($array);
?>
<hr>
<?php
