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
            // Получаем значение из столбцов B и C в указанной строке
            $columnB = $rows[$i][1] ?? null;
            $columnC = $rows[$i][2] ?? null;
            
            // Обрабатываем строку и проверяем правильные ответы
            processRow($columnB, $columnC);
        }
    } else {
        echo "Во второй строке нет данных.\n";
    }
} else {
    echo SimpleXLSX::parseError();
}

// Функция для обработки строки
function processRow($columnB, $columnC) {
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
    
    // Проверяем правильные ответы из столбца C
    $correctAnswers = explode("\n", $columnC);
    $correctFractions = [];
    
    foreach ($correctAnswers as $correctAnswer) {
        // Разбиваем строку на слово и правильную долю
        $parts = explode(' ', $correctAnswer);
        
        // Проверяем, содержит ли строка хотя бы два элемента
        if (count($parts) >= 2) {
            // Получаем слово и правильную долю
            $word = $parts[0];
            $correctFraction = floatval($parts[1]);
            
            // Записываем правильную долю в массив
            $correctFractions[$word] = $correctFraction;
        }
    }
    
    // Выводим доли каждого числа от общей суммы и проверяем их правильность с учетом погрешности
    foreach ($words as $word) {
        $number = $fractions[$word];
        $fraction = round($number / $totalSum, 6);
        $correctFraction = $correctFractions[$word] ?? null;
        
        echo "Слово: $word, Число: $number, Доля: $fraction";
        
        if ($correctFraction !== null) {
            if (abs($fraction - $correctFraction) <= 0.1) {
                echo " - Правильно\n";
            } else {
                echo " - Неправильно, правильная доля: $correctFraction\n";
            }
        } else {
            echo " - Нет правильного ответа\n";
        }
    }
    
    echo "\n"; // Добавляем пустую строку для разделения результатов обработки разных строк
}
?>
