<?php
define("NUM_E", 2.71828);

// вывод значения константы
echo "Число e равно " . NUM_E . "<br><br>";

// присваивание константы переменной
$num_e1 = NUM_E;
var_dump($num_e1);
echo "<br>";

// строковый тип
$num_e1 = (string)$num_e1;
var_dump($num_e1);
echo "<br>";

// целый тип
$num_e1 = (int)$num_e1;
var_dump($num_e1);
echo "<br>";

// логический тип
$num_e1 = (bool)$num_e1;
var_dump($num_e1);
