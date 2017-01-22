<?php
/* 
 * Напишите скрипт, выводящий таблицу из %n случайных чисел с чередованием фона строк.
 * Не использовать CSS.
 */

// Переменные для регулирования количества случайных чисел и столбцов
$number = 10;
$columns = 3;

// Переменные для визуального оформления: цвет фона, цвет текста
$table_style = 'border: 2px solid #161816; text-align: center;';
$bg_color_1 = '#555';
$bg_color_2 = '#ccc';
$color_1 = '#fff';
$color_2 = '#000';
$background = '';
$rgb_min = 0;
$rgb_max = 255;
$rgb_step = $rgb_max / ($number - 1);



// Задание А
// Выводим таблицу со случайными числами в один столбец
echo "<table style='{$table_style}'>"
	. "<th>Номер п/п</th><th>Случайное число</th>";

	// Определяем четную/нечетную строку и определяем фон, цвет текста
	for($i = 1; $i <= $number; $i++) {
		if($i % 2) {
			$background = $bg_color_1;
			$color = $color_1;
		} else {
			$background = $bg_color_2;
			$color = $color_2;
		}

		// Рендерим строки по порядку и столбцы со случайными цифрами
		echo "<tr style='background-color:{$background}; color: {$color}'>"
			. "<td>{$i}</td>"
			. "<td>" . rand(1, 100) . "</td>"
			. "</tr>";
	}

echo "</table><hr>";



// Задание Б
// Выводим таблицу со случайными числами в %n столбцов
echo "<table style='{$table_style}'>"
	. "<th>Номер п/п</th><th colspan='{$columns}'>Случайное число</th>";
	
	// Определяем четную/нечетную строку и определяем фон, цвет текста
	for($i = 1; $i <= $number; $i++) {
		if($i % 2) {
			$background = $bg_color_1;
			$color = $color_1;
		} else {
			$background = $bg_color_2;
			$color = $color_2;
		}

		// Рендерим строки по порядку и столбцы со случайными цифрами		
		echo "<tr style='background-color:{$background}; color: {$color}'>"
			. "<td>{$i}</td>";
			
			for($k = 1; $k <= $columns; $k++) {
				echo "<td>" . rand(1, 100) . "</td>";
			}
		
		echo "</tr>";
	}

echo "</table><hr>";


// Задание 2
// Выводим таблицу со случайными числами в %n столбцов + градиент
echo "<table style='{$table_style}'>"
	. "<th>Номер п/п</th><th colspan='{$columns}'>Случайное число</th>";

	// Определяем четную/нечетную строку и определяем фон
	for($i = 1; $i <= $number; $i++) {
		if($i % 2) {
			$background = $bg_color_1;
		} else {
			$background = $bg_color_2;
		}

		// Готовим фон и цвет текста к рендерингу
		$rgb_res = round($rgb_min, 0, PHP_ROUND_HALF_DOWN);
		$color = round($rgb_max, 0, PHP_ROUND_HALF_DOWN);

		// Устранение нечитаемости текста при совпадении оттенка с фоном
		switch($rgb_res) {
			case($rgb_res >= 0 && $rgb_res < 30):
				$color = '#999';
				break;			
			case($rgb_res >= 30 && $rgb_res < 80):
				$color = '#999';
				break;			
			case($rgb_res >= 80 && $rgb_res < 110):
				$color = '#999';
				break;			
			case($rgb_res >= 110 && $rgb_res < 196):
				$color = '#333';
				break;			
			case($rgb_res >= 196 && $rgb_res < 224):
				$color = '#222';
				break;			
			case($rgb_res >= 224 && $rgb_res < 252):
				$color = '#111';
				break;			
			case($rgb_res >= 252 && $rgb_res <= 255):
				$color = '#000';
				break;
			default:
				$color = '#fff';
		}
	
		// Рендерим строки по порядку и столбцы со случайными цифрами
		echo "<tr style='background-color: rgb(" . $rgb_res . "," . $rgb_res . "," . $rgb_res . "); color: {$color};'>"
			. "<td>{$i}</td>";
			
			for($k = 1; $k <= $columns; $k++) {
				echo "<td>" . rand(1, 100) . "</td>";
			}
		
		echo "</tr>";

		// Обновляем данные фона и цвета текста для новой итерации цикла
		$rgb_min += $rgb_step;
		$rgb_max -= $rgb_step;
	}

echo "</table><hr>";
?>