<?php
require 'vendor/autoload.php'; // Подключаем автозагрузку зависимостей

use Shuchkin\SimpleXLSX;

/*
Функция нахождения раздела с искомым left key
raw_node_data - словарь с информацией по разделам
left_key - искомый left key
Возвращает id раздела
*/
function findLeftKey($raw_node_data, $left_key){
    // проходимся последовательно по всем разделам и проверяем ключ
    foreach ($raw_node_data as $key => $value){
        if ($value["left_key"] == $left_key){
            return $key;
        }
    }
    // Если не смогли найти ключ, то возвращаем false
    return false;
}

/*
Функция нахождения корней дерева
raw_node_data - словарь с информацией по разделам
left_key - искомый left key
Возвращает массив id разделов
*/
function findRoots($raw_node_data, $left_key){
    $result = [];
    while(true){
        // находим id c искомым left_key
        $id = findLeftKey($raw_node_data, $left_key);
        // если не удалось найти раздел, то выходим из цикла
        if ($id === false){
            break;
        }
        // указываем следующий left key
        $left_key = $raw_node_data[$id]["right_key"] + 1;
        // добавляем id раздела в массив
        array_push($result, $id);
    }
    return $result;
}

/*
Рекурсивная функция отображения дерева
id - id корня дерева
node_data - словарь прямых потомков разделов. Ключ - id раздела. Значение - массив прямых потомков.
raw_node_data - словарь с информацией по разделам
level - уровень вложенности
string - указатель на строку, в которую будем печатать дерево
*/
function printTree($id, $node_data, $raw_node_data, $level, &$string){
    $string .= str_repeat("-", $level); // Печатаем знак "-" в соответствии с уровнем вложенности 
    $string .= $raw_node_data[$id]["name"]; // Печатаем название раздела
    $string .= "\n"; // Перевод строки
    // Проходимся по прямым потомкам и вызываем эту же функцию с каждым
    foreach ($node_data[$id] as $key => $value) {
        printTree($value, $node_data, $raw_node_data, $level + 1, $string);
    }
}

/*
Функция, которая находит прямых потомков для узла дерева
id - id раздела, для которого находим потомков
node_data - указатель на словарь прямых потомков разделов
raw_node_data - словарь с информацией по разделам
*/
function getChilds($id, &$node_data, $raw_node_data){
    $left_key = $raw_node_data[$id]["left_key"] + 1;
    $childs = findRoots($raw_node_data, $left_key);
    $node_data[$id] = $childs;
}

/*
Функция получения результата для каждого ряда в файле
file_path - путь к файлу с информацией о разделах
Возвращает массив отформатированных строк по строкам из файла
*/
function getResults($file_path){
    // Используем SimpleXLSX для парсинга Excel файла
    if ($xlsx = SimpleXLSX::parse($file_path)) {
        $rows = $xlsx->rows();

        $results = [];
        // Читаем данные с 7 по 13 строки (индексы сдвинуты, так как $rows 0-базирован)
        for ($i = 6; $i <= 12; $i++) {
            if (isset($rows[$i][1])) {
                $raw_node_data = []; // словарь с информацией о разделах
                $lines = explode("\n", $rows[$i][1]); // Обрабатываем несколько строк в одной ячейке
                foreach ($lines as $line) {
                    $data = explode(" ", trim($line));
                    if (count($data) >= 4) {
                        $id = $data[0];
                        $raw_node_data[$id]["name"] = $data[1];
                        $raw_node_data[$id]["left_key"] = $data[2];
                        $raw_node_data[$id]["right_key"] = $data[3];
                    }
                }

                // Инициализируем словарь node_data
                $node_data = [];
                foreach ($raw_node_data as $key => $value) {
                    getChilds($key, $node_data, $raw_node_data);
                }

                // Находим корни и печатаем деревья для этой конкретной строки
                $result = "";
                $roots = findRoots($raw_node_data, 1);
                foreach ($roots as $key => $value) {
                    printTree($value, $node_data, $raw_node_data, 0, $result);
                }
                $results[] = trim($result); // Сохраняем результат для этой строки, убирая лишний перевод строки
            } else {
                $results[] = ""; // Если нет данных в столбце B, сохраняем пустой результат
            }
        }

        return $results;
    } else {
        return SimpleXLSX::parseError();
    }
}

/*
Функция получения ожидаемого результата для каждого ряда в файле
file_path - путь к файлу с информацией о разделах
Возвращает массив предполагаемых строк из столбца C
*/
function getExpectedResults($file_path) {
    // Используем SimpleXLSX для парсинга Excel файла
    if ($xlsx = SimpleXLSX::parse($file_path)) {
        $rows = $xlsx->rows();

        $expectedResults = [];
        // Читаем данные с 7 по 13 строки в столбце C (индексы сдвинуты, так как $rows 0-базирован)
        for ($i = 6; $i <= 12; $i++) {
            if (isset($rows[$i][2])) {
                $expectedResults[] = trim($rows[$i][2]); // Сохраняем ожидаемый результат
            } else {
                $expectedResults[] = ""; // Если нет данных в столбце C, сохраняем пустой результат
            }
        }

        return $expectedResults;
    } else {
        return SimpleXLSX::parseError();
    }
}

// Пример использования
$file_path = 'test.xlsx';
$results = getResults($file_path);
$expectedResults = getExpectedResults($file_path);

// Сравниваем результаты с ожидаемыми и выводим результат сравнения
foreach ($results as $index => $result) {
    $expected = $expectedResults[$index];
    $line_number = $index + 7; // Корректируем индекс для соответствия номерам строк в Excel
    if ($result === $expected) {
        echo "Строка $line_number: PASS\n";
    } else {
        echo "Строка $line_number: FAIL\n";
        echo "Ожидалось:\n$expected\n";
        echo "Получено:\n$result\n";
        echo "---\n";
    }
}
?>
