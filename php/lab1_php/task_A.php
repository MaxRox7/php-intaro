<?php

// Путь к файлу
$file_path = 'tests\A\001.dat';

// Чтение файла
$file_contents = file_get_contents($file_path);

// Разделение содержимого файла по строкам
$file_lines = explode("\n", $file_contents);

// Создание двумерного массива данных
$data_arrays = [];

// Пока есть строки для обработки
while (!empty($file_lines)) {
    // Получение количества строк для обработки
    $lines_to_process = (int) array_shift($file_lines);
    
    // Создание массива данных для текущей порции
    $data_array = [];
    for ($i = 0; $i < $lines_to_process; $i++) {
        // Разделение строки на отдельные значения
        $line_values = explode(" ", array_shift($file_lines));
        // Преобразование строковых чисел в вещественные числа
        $line_values = array_map('floatval', $line_values);
        // Добавление отдельных значений в массив данных
        $data_array[] = $line_values;
    }
    
    // Добавление массива данных в список, каждый в свою переменную
    $data_arrays[] = $data_array;
}

// Сохранение массивов данных в отдельные переменные
$data_array1 = $data_arrays[0];
$data_array2 = $data_arrays[1];

// Вычисление суммы чисел под индексом 1 в первом массиве
$sum_of_index_1 = 0.0;
foreach ($data_array1 as $value) {
    $sum_of_index_1 += (float)$value[1];
}

echo "Исходная сумма чисел: $sum_of_index_1\n";

// Поиск совпадений по индексу 0 в обоих массивах и сравнение значений по индексу 2 и 4
foreach ($data_array1 as $value1) {
    foreach ($data_array2 as $value2) {
        if ($value1[0] == $value2[0]) {
            echo "Совпадение индекса 0: {$value1[0]}\n";
            if ($value1[2] != $value2[4]) {
                echo "Значение индекса 2 первого массива ({$value1[2]}) не совпадает с значением индекса 4 второго массива ({$value2[4]}), вычитаем число из sum_of_index_1\n";
                $sum_of_index_1 -= (float)$value1[1];
            } else {
                echo "Значение индекса 2 первого массива ({$value1[2]}) совпадает с значением индекса 4 второго массива ({$value2[4]})\n";
                switch ($value1[2]) {
                    case 'L':
                        echo "Умножаем число из первого массива ({$value1[1]}) на число, содержащееся в индексе 1 во втором массиве ({$value2[1]}), и прибавляем это значение к sum_of_index_1\n";
                        $sum_of_index_1 += (float)$value1[1] * (float)$value2[1];
                        break;
                    case 'R':
                        echo "Умножаем число из первого массива ({$value1[1]}) на число, содержащееся в индексе 2 во втором массиве ({$value2[2]}), и прибавляем это значение к sum_of_index_1\n";
                        $sum_of_index_1 += (float)$value1[1] * (float)$value2[2];
                        break;
                    case 'D':
                        echo "Умножаем число из первого массива ({$value1[1]}) на число, содержащееся в индексе 3 во втором массиве ({$value2[3]}), и прибавляем это значение к sum_of_index_1\n";
                        $sum_of_index_1 += (float)$value1[1] * (float)$value2[3];
                        break;
                }
            }
            echo "Текущая сумма чисел: $sum_of_index_1\n";
        }
    }
}

// Вывод суммы чисел
echo "Сумма чисел после всех вычислений: $sum_of_index_1\n";

?>
