<h2>1. Календарь</h2>

<?php
$month = 5;   // май
$year = 2026;

echo "<b>Месяц:</b> $month, <b>Год:</b> $year <br><br>";

$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

for ($day = 1; $day <= $daysInMonth; $day++) {
    echo $day . " ";
}
?>
<hr>
