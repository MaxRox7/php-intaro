<?php

require 'vendor/autoload.php'; // Подключаем автозагрузчик Composer

use Shuchkin\SimpleXLSX;

function minifyCSS($css) {
    // Remove comments
    $css = preg_replace('!/\*.*?\*/!s', '', $css);

    // Remove empty styles
    $css = preg_replace('/[^{}]+\{\s*\}/', '', $css);

    // Replace multiple spaces, tabs, and newlines with a single space
    $css = preg_replace('/[\r\n\t]+/', ' ', $css);

    // Remove spaces around {, }, :, ; and after commas
    $css = preg_replace('/\s*([{}:;,])\s*/', '$1', $css);

    // Shorten hex colors (#ffffff to #fff)
    $css = preg_replace('/#([0-9a-f])\1([0-9a-f])\2([0-9a-f])\3\b/i', '#$1$2$3', $css);

    // Replace named colors with their equivalents
    $css = str_ireplace(array(
        '#CD853F',
        '#FFC0CB',
        '#DDA0DD',
        '#F00',
        '#FFFAFA',
        '#D2B48C'
    ), array(
        'peru',
        'pink',
        'plum',
        'red',
        'snow',
        'tan'
    ), $css);

    // Consolidate margin properties into shorthand form
    $css = preg_replace('/\bmargin(-(top|right|bottom|left))?\s*:\s*((\d+px\s*){1,4});?/i', 'margin:$3;', $css);

    // Consolidate padding properties into shorthand form
    $css = preg_replace('/\bpadding(-(top|right|bottom|left))?\s*:\s*((\d+px\s*){1,4});?/i', 'padding:$3;', $css);

    // Remove duplicate semicolons
    $css = preg_replace('/;;+/', ';', $css);

    // Trim leading and trailing spaces
    $css = trim($css);

    return $css;
}




function parseData($filePath) {
    $xlsx = SimpleXLSX::parse($filePath);
    if (!$xlsx) {
        die(SimpleXLSX::parseError());
    }

    $inputData = [];
    $expectedOutput = [];
    
    foreach ($xlsx->rows() as $index => $row) {
        if ($index >= 21 && $index <= 31) { // строки с 22 по 32 (индексы с 21 по 31)
            $inputData[] = $row[1];
            $expectedOutput[] = $row[2];
        }
    }

    return [$inputData, $expectedOutput];
}

function main() {
    $filePath = 'test.xlsx'; // Укажите путь к вашему файлу
    list($inputData, $expectedOutput) = parseData($filePath);

    $totalTests = count($inputData);
    $passedTests = 0;
    
    foreach ($inputData as $index => $data) {
        $minifiedCSS = minifyCSS($data);
        $expectedCSS = $expectedOutput[$index];
        echo 'Результат для строки ' . ($index + 22) . ': ' . $minifiedCSS . PHP_EOL;
        echo 'Ожидаемый результат: ' . $expectedCSS . PHP_EOL;
        if ($minifiedCSS === $expectedCSS) {
            echo 'Тест пройден' . PHP_EOL;
            $passedTests++;
        } else {
            echo 'Тест не пройден' . PHP_EOL;
        }
    }

    $failedTests = $totalTests - $passedTests;
    echo PHP_EOL;
    echo 'Итоговый отчет:' . PHP_EOL;
    echo 'Пройдено тестов: ' . $passedTests . PHP_EOL;
    echo 'Не пройдено тестов: ' . $failedTests . PHP_EOL;
    echo 'Соотношение: ' . $passedTests . ' / ' . $totalTests . PHP_EOL;
}

main();
