<?php
/* 
 * Задание 1. Напишите скрипт, которой для числа $x вычисляет значение $y, равное
 * 1 – если $x положительно
 * 0 – если $x равно 0 и
 * -1 – если $x отрицательно
 * 
*/

$x = 1;
$y = '';

if($x > 0) {
	$y = 1;
}elseif($x == 0) {
	$y = 0;
}else {
	$y = -1;
}

echo $y . "<hr>";

?>

<?php
/* 
 * Задание 2. Напишите скрипт, определяющий сумму максимального и минимального 
 * из трех чисел $a, $b, $c.
 *
*/

$a = 1;
$b = 3;
$c = 5;

$result = (min($a, $b, $c)) + (max($a, $b, $c));

echo $result . "<hr>";

?>

<?php
/* Задание 3. Напишите скрипт, определяющий максимальное из четырех чисел 
 * $a, $b, $c, $d.
 *
*/
$a = 1;
$b = 3;
$c = 5;
$d = 7;

$result = max($a, $b, $c, $d);

echo $result . "<hr>";

?>

<?php
/*
 * Задание 4. Известны длина и ширина сумки $a, $b, а также длина и ширина 
 * товара $c, $d. Напишите скрипт, определяющий, можно ли товар упаковать 
 * в сумку. Предусмотреть возможность ввода длины и ширины в произвольном 
 * порядке, например, 20, 30 или 30, 20. Усложнение задачи: добавьте еще 
 * высоту сумки и высоту товара. Учтите, что товар можно повернуть.
 *
*/

// Set the parameters of the bag
$bag_width = 100;
$bag_height = 40;

// Set the parameters of the product
$prod_width = 90;
$prod_height = 30;

// Set the notodocations for the $result
$true = 'This product will fit in the package';
$false = 'This product will not fit in the bag';


// Comparison the parameters
if($prod_width < $bag_width && $prod_height < $bag_height) {
	$result = $true;
} elseif($prod_width < $bag_height && $prod_height < $bag_width) {
	$result = $true;
} else {
	$result = $false;
}

echo $result;

?>