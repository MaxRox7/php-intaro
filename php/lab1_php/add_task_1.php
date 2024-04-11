<?php

function doubleNumbersInQuotes($string) {
    // Используем регулярное выражение для поиска чисел в кавычках и их замены
    return preg_replace_callback("/'(\d+)'/", function($matches) {
        // Увеличиваем число в два раза
        $number = $matches[1] * 2;
        return $number;
    }, $string);
}

// Пример использования
$string = "2aaa'3'bbb'4'";
$result = doubleNumbersInQuotes($string);
echo $result; 
?>
