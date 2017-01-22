<?php
/*
 * Имеется 2 варианта размещения вклада суммой S в банк. 
 * В первом случае ежегодно начисляется 30 процентов.
 * Во втором случае ежемесячно начисляется 3 процента.
 * Напишите скрипт, который вычисляет и выводит сумму вклада по первому и
 * второму вариантам через 1, 2 , 3 и 4 года.
*/

// Задаем сумму вклада
$money_1 = $money_2 = 100;

// Устанавливаем расчетные сроки
$months = 12;
$year_1 = $months * 1;
$year_2 = $months * 2;
$year_3 = $months * 3;
$year_4 = $months * 4;

// Стили для оформления таблицы
$th_style = "style='background:#4495cc; padding: 2px 5px;'";
$tr_payment = "style='background: #ffd47c; font-weight: bold;'";
$tr_default = "style='background: rgba(153,153,153,0.5);'";

// Начало таблицы
echo "<table><th {$th_style}>Номер месяца</th><th {$th_style}>Сумма с капитализацией под 3% в месяц</th><th {$th_style}>Сумма с капитализацией под 30% в год</th>";

// Рассчитываем и выводим результаты
for($i = 1; $i <= $year_4; $i++) {

	// Изменяем внешний вид таблицы по платежным датам: 1, 2, 3 и 4 года
	if($i == $year_1 || $i == $year_2 || $i == $year_3 || $i == $year_4) {
		echo "<tr {$tr_payment}>";
	}else {
		echo "<tr {$tr_default}>";
	}

	// Рассчет для 30% годовых
	switch($i) {
		case $year_1:
			$money_2 = $money_2 + ($money_2 * 0.3);
			$res_2 = $money_2;
			break;		
		case $year_2:
			$money_2 = $money_2 + ($money_2 * 0.3);
			$res_2 = $money_2;
			break;		
		case $year_3:
			$money_2 = $money_2 + ($money_2 * 0.3);
			$res_2 = $money_2;
			break;		
		case $year_4:
			$money_2 = $money_2 + ($money_2 * 0.3);
			$res_2 = $money_2;
			break;
		default:
			$res_2 = 'Начисление процентов на последний месяц года.';
	}

	// Рассчет для 3% в месяц
	$money_1 = $money_1 + ($money_1 * 0.03);
	$res = $money_1;
	
	echo "<td>{$i}</td><td>{$res}</td><td>{$res_2}</td>";	
	echo "</tr>";
}

// Конец таблицы
echo "</table>";

?>