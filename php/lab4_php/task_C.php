<?php
require 'vendor/autoload.php';

use Shuchkin\SimpleXLSX;

$xlsx = SimpleXLSX::parse('test.xlsx');

if ($xlsx) {
    // Получаем все строки из первой (нулевой) страницы
    $rows = $xlsx->rows();
    
    // Проверяем, есть ли хотя бы две строки
    if (isset($rows[1])) {
        // Обработка строк с 15 по 20
        for ($i = 14; $i <= 19; $i++) {
            // Получаем значение из столбца B в указанной строке
            $columnB = $rows[$i][1] ?? null;
            
            // Обрабатываем строку
            processRow($columnB);
        }
    } else {
        echo "Во второй строке нет данных.\n";
    }
} else {
    echo SimpleXLSX::parseError();
}

// Функция для обработки строки
function processRow($columnB) {
    // Разбиваем поле на строки
    $fieldRows = explode("\n", $columnB);
    
    // Инициализируем переменные для суммы чисел и для долей каждого числа от общей суммы
    $totalSum = 0;
    $fractions = [];
    $words = [];
    
    // Проходим по каждой строке в поле
    foreach ($fieldRows as $row) {
        // Разбиваем строку на слова
        $parts = explode(' ', $row);
        
        // Проверяем, содержит ли строка хотя бы два элемента
        if (count($parts) >= 2) {
            // Получаем слово и число
            $word = $parts[0];
            $number = intval($parts[1]);
            
            // Добавляем число к общей сумме
            $totalSum += $number;
            
            // Записываем число и слово в массивы
            $fractions[$word] = $number;
            $words[] = $word;
        }
    }
    
    // Выводим сумму всех чисел
    echo "Сумма всех чисел: $totalSum\n";
    
    // Выводим доли каждого числа от общей суммы
    foreach ($words as $word) {
        $number = $fractions[$word];
        $fraction = round($number / $totalSum, 6);
        echo "Слово: $word, Число: $number, Доля: $fraction\n";
    }
    
    echo "\n"; // Добавляем пустую строку для разделения результатов обработки разных строк
}
?>
