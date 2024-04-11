<?php

// Путь к файлу
$file_path = "tests/C/005.dat";

// Открываем файл для чтения
$file = fopen($file_path, "r");

// Проверка на успешное открытие файла
if ($file === false) {
    die("Unable to open file!");
}

// Читаем файл построчно
while (!feof($file)) {
    // Получаем строку из файла
    $line = trim(fgets($file));

    // Если строка пустая, пропускаем её
    if (empty($line)) {
        continue;
    }

    // Разбиваем строку на части, используя регулярное выражение
    preg_match('/<([^>]*)>\s*([PDENS])\s*(-?\d*)\s*(-?\d*)/', $line, $matches);

    // Проверяем, были ли найдены совпадения
    if (count($matches) < 2) {
        echo "FAIL\n";
        continue;
    }

    // Получаем данные в скобках и тип валидации
    $data = $matches[1];
    $validation_type = $matches[2];

    // Проверяем тип валидации и соответствующие данные
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
            // Неизвестный тип валидации
            echo "Unknown validation type\n";
            break;
    }
}

// Закрываем файл
fclose($file);

?>
