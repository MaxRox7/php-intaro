<?php

// Получаем список файлов .dat в директории
$dat_files = glob("tests/C/*.dat");

// Проходим по каждому файлу .dat
foreach ($dat_files as $dat_file) {
    // Открываем .dat файл для чтения
    $file = fopen($dat_file, "r");

    // Проверка на успешное открытие файла
    if ($file === false) {
        die("Unable to open file: $dat_file");
    }

    // Выводим информацию о текущем тесте
    echo "Running test for $dat_file:\n";

    // Подготавливаем переменную для хранения фактического вывода
    $output = [];

    // Читаем файл .dat построчно
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
            $output[] = "FAIL";
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
                    $output[] = "FAIL";
                } else {
                    $output[] = "OK";
                }
                break;
                case 'D':
                    // Дата и время: d.m.Y H:i
                    $date_format = 'd.m.Y H:i';
                    if (!preg_match('/^([0-2]?[0-9]|3[01])\.([0]?[1-9]|1[0-2])\.\d{4} ([01]?[0-9]|2[0-3]):([0-5][0-9])$/', $data)) {
                        $output[] = "FAIL";
                    } else {
                        // Разбиваем дату и время на компоненты
                        $date_components = explode(' ', $data);
                        $date_part = $date_components[0];
                        $time_part = $date_components[1];
                        
                        // Разбиваем дату на компоненты
                        $date_parts = explode('.', $date_part);
                        $day = intval($date_parts[0]);
                        $month = intval($date_parts[1]);
                        $year = intval($date_parts[2]);
                        
                        // Проверяем, является ли год високосным
                        $is_leap_year = ($year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0));
                        
                        // Проверяем, если дата 29 февраля в невисокосном году
                        if ($day == 29 && $month == 2 && !$is_leap_year) {
                            $output[] = "FAIL"; // Неверная дата в невисокосном году
                        } else {
                            // Создаем объект DateTime
                            $date = DateTime::createFromFormat($date_format, $data);
                            
                            // Проверяем, была ли успешно создана дата
                            if ($date instanceof DateTime) {
                                $hour = intval($date->format('H'));
                                $minute = intval($date->format('i'));
                                
                                // Проверка диапазона значений часов и минут
                                if ($hour >= 0 && $hour <= 23 && $minute >= 0 && $minute <= 59) {
                                    // Если все проверки пройдены успешно
                                    $output[] = "OK";
                                } else {
                                    $output[] = "FAIL"; // Неверный формат времени
                                }
                            } else {
                                $output[] = "FAIL"; // Неверный формат даты и времени
                            }
                        }
                    }
                    break;
                
                
                     
                case 'E':
                    // Электронная почта
                    if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9_]{3,29}@[a-zA-Z]{2,30}\.[a-z]{2,10}$/', $data)) {
                        $output[] = "FAIL";
                    } else {
                        $output[] = "OK";
                    }
                    break;
                
            case 'S':
                // Строка: учитываем длину
                $min_length = intval($matches[3]);
                $max_length = intval($matches[4]);
                $data_length = strlen($data);
                if ($data_length < $min_length || $data_length > $max_length) {
                    
                    $output[] = "FAIL";
                } else {
                    $output[] = "OK";
                }
                break;
            case 'N':
    // Число: учитываем пределы
    if (!preg_match('/^-?\d+$/', $data)) {
        $output[] = "FAIL";
    } else {
        $number = intval($data);
        $min_value = intval($matches[3]);
        $max_value = intval($matches[4]);
        if ($number < $min_value || $number > $max_value) {
            $output[] = "FAIL";
        } else {
            $output[] = "OK";
        }
    }
    break;

            default:
                // Неизвестный тип валидации
                $output[] = "Unknown validation type";
                break;
        }
    }

    // Закрываем файл .dat
    fclose($file);

    // Формируем путь к соответствующему файлу .ans
    $ans_file = str_replace('.dat', '.ans', $dat_file);

    // Считываем ожидаемый вывод из файла .ans
    $expected_output = file($ans_file, FILE_IGNORE_NEW_LINES);

    // Сравниваем ожидаемый и фактический вывод
    $test_passed = true;
    for ($i = 0; $i < count($expected_output); $i++) {
        if ($output[$i] !== $expected_output[$i]) {
            $test_passed = false;
            break;
        }
    }

    // Выводим результат теста
    if ($test_passed) {
        echo "Test for $dat_file: PASSED\n";
    } else {
        echo "Test for $dat_file: FAILED\n";
        echo "Expected output:\n";
        foreach ($expected_output as $line) {
            echo "$line\n";
        }
        echo "Actual output:\n";
        foreach ($output as $line) {
            echo "$line\n";
        }
    }

    echo "==============================\n";
}

?>