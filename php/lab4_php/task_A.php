<?php

require 'vendor/autoload.php'; // Путь к библиотеке PHP Spreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

// Чтение файла test.xlsx
$inputFileName = 'test.xlsx';
$spreadsheet = IOFactory::load($inputFileName);
$sheet = $spreadsheet->getActiveSheet();

// Массив для хранения входных и ожидаемых выходных данных
$test_data = [];

// Чтение входных и ожидаемых выходных данных из файла Excel
foreach ($sheet->getRowIterator(2) as $row) {
    $input_data = $sheet->getCell('B' . $row->getRowIndex())->getValue();
    $expected_output = $sheet->getCell('C' . $row->getRowIndex())->getValue();
    $test_data[] = [
        'input' => $input_data,
        'expected_output' => $expected_output
    ];
}

// Функция для обработки входных данных и сравнения с ожидаемыми результатами
function process_test_data($input_data)
{
    // Ваш код для обработки входных данных и получения выходных данных
    // Замените этот код на ваш реальный код обработки данных

    $output_data = ''; // Здесь должны быть выходные данные

    return $output_data;
}

// Проверка каждого теста
foreach ($test_data as $test) {
    $input = $test['input'];
    $expected_output = $test['expected_output'];

    // Обработка входных данных
    $output = process_test_data($input);

    // Сравнение полученного вывода с ожидаемым выводом
    if ($output == $expected_output) {
        echo "Тест пройден: входные данные - $input, ожидаемый вывод - $expected_output\n";
    } else {
        echo "Тест не пройден: входные данные - $input, ожидаемый вывод - $expected_output, полученный вывод - $output\n";
    }
}
