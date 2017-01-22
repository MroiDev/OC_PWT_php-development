<?php
/* 
 * Напишите скрипт, выводящий таблицу из %n случайных чисел с чередованием фона строк.
 *
 */

// Переменные для регулирования количества случайных чисел и столбцов
$str = 10;
$columns = 3;

// Переменные для визуального оформления: цвет фон, цвет текста
$bg_color_1 = '#555';
$bg_color_2 = '#ccc';
$color_1 = '#fff';
$color_2 = '#000';
$background = '';

// Выводим таблицу со случайными числами в один столбец - задание А
echo "<table style='border: 2px solid #161816; text-align: center;'>"
	. "<th>Номер п/п</th><th>Случайное число</th>";
	
	for($i = 1; $i <= $str; $i++) {
		if($i % 2) {
			$background = $bg_color_1;
			$color = $color_1;
		} else {
			$background = $bg_color_2;
			$color = $color_2;
		}
		
		echo "<tr style='background-color:{$background}; color: {$color}'>"
			. "<td>{$i}</td>"
			. "<td>" . rand(1, 100) . "</td>"
			. "</tr>";
	}

echo "</table><hr>";

// Выводим таблицу со случайными числами в %n столбцов - задание Б
echo "<table style='border: 2px solid #161816; text-align: center;'>"
	. "<th>Номер п/п</th><th colspan='{$columns}'>Случайное число</th>";
	
	for($i = 1; $i <= $str; $i++) {
		if($i % 2) {
			$background = $bg_color_1;
			$color = $color_1;
		} else {
			$background = $bg_color_2;
			$color = $color_2;
		}
		
		echo "<tr style='background-color:{$background}; color: {$color}'>"
			. "<td>{$i}</td>";
			
			for($k = 1; $k <= $columns; $k++) {
				echo "<td>" . rand(1, 100) . "</td>";
			}
		
		echo "</tr>";
	}

echo "</table>";
?>