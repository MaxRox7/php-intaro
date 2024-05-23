<?php
require 'vendor/autoload.php';

use Shuchkin\SimpleXLSX;

$xlsx = SimpleXLSX::parse('test.xlsx');

if ($xlsx) {
    // Получаем все строки из первой (нулевой) страницы
    $rows = $xlsx->rows();
    
    // Проверяем, есть ли хотя бы пять строк
    if (count($rows) >= 5) {
        // Проходимся по строкам с 2 по 5
        for ($i = 1; $i <= 4; $i++) {
            // Получаем значения из столбцов B и C в текущей строке
            $data = $rows[$i][1] ?? null; // Получаем значение из столбца B
            $expected_output = $rows[$i][2] ?? null; // Получаем значение из столбца C

            // Разделяем строку на слова и даты
            $lines = explode("\n", $data);
            $identifiers = []; // Ассоциативный массив для хранения информации об идентификаторах
            foreach ($lines as $line) {
                if (preg_match('/^(\S+\d*)\s+(\d{2}\.\d{2}\.\d{4})\s+(\d{2}:\d{2}:\d{2})/', $line, $matches)) {
                    $word = $matches[1];
                    $date = $matches[2];
                    $time = $matches[3];
                    // Если идентификатор встречается впервые, добавляем его в массив с информацией о повторениях и времени последнего упоминания
                    if (!isset($identifiers[$word])) {
                        $identifiers[$word] = [
                            'count' => 1,
                            'last_datetime' => "$date $time"
                        ];
                    } else {
                        // Иначе увеличиваем количество повторений и обновляем время последнего упоминания, если оно позднее
                        $identifiers[$word]['count']++;
                        if (strtotime("$date $time") > strtotime($identifiers[$word]['last_datetime'])) {
                            $identifiers[$word]['last_datetime'] = "$date $time";
                        }
                    }
                } else {
                    echo "Не удалось разделить строку на слово, дату и время.\n";
                }
            }
            // Формируем фактический вывод для текущей строки
            $actual_output = '';
            foreach ($identifiers as $word => $info) {
                $actual_output .= "{$info['count']} $word {$info['last_datetime']}\n";
            }

            // Удаляем символы новой строки из фактического и ожидаемого вывода перед сравнением
            $actual_output = trim($actual_output);
            $expected_output = trim($expected_output);

            // Сравниваем ожидаемый вывод с фактическим
            if ($actual_output === $expected_output) {
                echo "Тест для строки $i пройден: вывод соответствует данным из столбца C.\n";
            } else {
                echo "Тест для строки $i не пройден: вывод не соответствует данным из столбца C.\n";
                echo "Ожидаемый вывод для строки" ."\n" . "$expected_output\n";
                echo "Наш вывод для строки". "\n" . "$actual_output\n";
            }
        }
    } else {
        echo "Недостаточно данных для проведения теста.\n";
    }
} else {
    echo SimpleXLSX::parseError();
}
?>
