<?php

// Путь к директории с файлами тестов
$dir_path = "tests/C/";

// Получаем список файлов в директории
$files = glob($dir_path . "*.dat");

// Проходим по каждому файлу в директории
foreach ($files as $file_path) {
    // Получаем номер файла из имени
    $file_number = basename($file_path, ".dat");

    // Формируем путь к файлу с ожидаемыми результатами (.ans)
    $expected_result_path = $dir_path . $file_number . ".ans";

    // Открываем файл с ожидаемыми результатами
    $expected_result_file = fopen($expected_result_path, "r");

    // Проверка на успешное открытие файла с ожидаемыми результатами
    if ($expected_result_file === false) {
        echo "Unable to open expected result file for test $file_number!\n";
        continue;
    }

    // Открываем файл с тестовыми данными
    $file = fopen($file_path, "r");

    // Проверка на успешное открытие файла с тестовыми данными
    if ($file === false) {
        echo "Unable to open test file $file_number!\n";
        fclose($expected_result_file);
        continue;
    }

    // Читаем файл с тестовыми данными построчно
    while (!feof($file)) {
        // Получаем строку из файла
        $line = trim(fgets($file));

        // Если строка пустая, пропускаем её
        if (empty($line)) {
            continue;
        }

        // Разбиваем строку и проводим валидацию
        preg_match('/<([^>]*)>\s*([PDENS])\s*(-?\d*)\s*(-?\d*)/', $line, $matches);

        // Проверяем, были ли найдены совпадения
        if (count($matches) < 2) {
            echo "FAIL\n";
            continue;
        }

        // Получаем данные в скобках и тип валидации
        $data = $matches[1];
        $validation_type = $matches[2];

        // Проводим валидацию в зависимости от типа
        switch ($validation_type) {
            case 'P':
                // Номер телефона: +7 (999) 999-99-99
                if (!preg_match('/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/', $data)) {
                    echo "FAIL\n";
                } else {
                    echo "OK\n";
                }
                break;
            case 'D':
                // Дата и время: d.m.Y H:i
                $date_format = 'd.m.Y H:i';
                $date = DateTime::createFromFormat($date_format, $data);
                if (!$date || $date->format($date_format) !== $data) {
                    echo "FAIL\n";
                } else {
                    echo "OK\n";
                }
                break;
            case 'E':
                // Электронная почта
                if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9_]{3,29}@[a-zA-Z]{2,30}\.[a-zA-Z]{2,10}$/', $data)) {
                    echo "FAIL\n";
                } else {
                    echo "OK\n";
                }
                break;
            case 'S':
                // Строка: учитываем длину
                $min_length = intval($matches[3]);
                $max_length = intval($matches[4]);
                $data_length = strlen($data);
                if ($data_length < $min_length || $data_length > $max_length) {
                    echo "FAIL\n";
                } else {
                    echo "OK\n";
                }
                break;
            case 'N':
                // Число: учитываем пределы
                $min_value = intval($matches[3]);
                $max_value = intval($matches[4]);
                $number = intval($data);
                if ($number < $min_value || $number > $max_value) {
                    echo "FAIL\n";
                } else {
                    echo "OK\n";
                }
                break;
            default:
                echo "Unknown validation type: $validation_type\n";
                break;
        }
    }

    // Закрываем файлы после обработки
    fclose($file);
    fclose($expected_result_file);
}

?>
