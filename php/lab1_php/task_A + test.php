<?php

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

    // Обработка данных, как в оригинальном коде
    $data_arrays = [];
    while (!empty($file_lines)) {
        $lines_to_process = (int)array_shift($file_lines);
        $data_array = [];
        for ($i = 0; $i < $lines_to_process; $i++) {
            $line_values = explode(" ", array_shift($file_lines));
            $data_array[] = $line_values;
        }
        $data_arrays[] = $data_array;
    }
    $data_array1 = $data_arrays[0];
    $data_array2 = $data_arrays[1];

    // Вычисление sum_of_index_1
    $sum_of_index_1 = 0;
    foreach ($data_array1 as $value1) {
        foreach ($data_array2 as $value2) {
            if ($value1[0] == $value2[0]) {
                if ($value1[2] != $value2[4]) {
                    $sum_of_index_1 -= (int)$value1[1];
                } else {
                    switch ($value1[2]) {
                        case 'L':
                            $sum_of_index_1 += (int)$value1[1] * (float)$value2[1] - (int)$value1[1];
                            break;
                        case 'R':
                            $sum_of_index_1 += (int)$value1[1] * (float)$value2[2] - (int)$value1[1];
                            break;
                        case 'D':
                            $sum_of_index_1 += (int)$value1[1] * (float)$value2[3] - (int)$value1[1];
                            break;
                    }
                }
            }
        }
    }

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
