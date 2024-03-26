<?php
require_once 'task_A + test.php';

function run_test($test_name) {
    // Путь к файлу с данными
    $data_file = "tests\\$test_name.dat";
    // Путь к файлу с ожидаемым результатом
    $expected_result_file = "tests\\$test_name.ans";

    // Чтение файла с ожидаемым результатом
    $expected_result = intval(file_get_contents($expected_result_file));

    // Чтение файла с данными
    $file_contents = file_get_contents($data_file);
    $file_lines = explode("\n", $file_contents);

    // Сравнение результата с ожидаемым результатом
    if ($sum_of_index_1 == $expected_result) {
        echo "Test $test_name passed!\n";
    } else {
        echo "Test $test_name failed! Expected: $expected_result, Actual: $sum_of_index_1\n";
    }

}

// Запуск тестов
for ($i = 1; $i <= 8; $i++) {
    $test_name = sprintf("A\\%03d", $i);
    run_test($test_name);
}


?>