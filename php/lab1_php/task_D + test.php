<?php

// Функция для поиска кратчайшего пути в графе с помощью алгоритма Дейкстры
function dijkstra($graph, $source, $destination) {
    $n = count($graph);
    $distances = array_fill(0, $n, PHP_INT_MAX);
    $visited = array_fill(0, $n, false);
    
    $distances[$source] = 0;
    
    for ($count = 0; $count < $n - 1; $count++) {
        $minDist = PHP_INT_MAX;
        $minIndex = -1;
        
        for ($i = 0; $i < $n; $i++) {
            if (!$visited[$i] && $distances[$i] <= $minDist) {
                $minDist = $distances[$i];
                $minIndex = $i;
            }
        }
        
        $visited[$minIndex] = true;
        
        for ($i = 0; $i < $n; $i++) {
            if (!$visited[$i] && $graph[$minIndex][$i] && $distances[$minIndex] != PHP_INT_MAX && $distances[$minIndex] + $graph[$minIndex][$i] < $distances[$i]) {
                $distances[$i] = $distances[$minIndex] + $graph[$minIndex][$i];
            }
        }
    }
    
    return ($distances[$destination] == PHP_INT_MAX) ? -1 : $distances[$destination];
}


// Функция для обработки запросов
function processQueries($graph, $queries) {
    $results = [];
    foreach ($queries as $query) {
        $source = $query[0];
        $destination = $query[1];
        $action = $query[2];
        
        if ($action == "?") {
            $results[] = dijkstra($graph, $source, $destination);
        } elseif ($action == -1) {
            $graph[$source][$destination] = 0;
            $graph[$destination][$source] = 0;
        } else {
            $graph[$source][$destination] = $action;
            $graph[$destination][$source] = $action;
        }
    }
    return $results;
}

function run_test($test_name) {
  
    $stdin = fopen("tests\\$test_name.dat", 'r');
  
    $expected_result_file = "tests\\$test_name.ans";

    // Чтение файла с ожидаемым результатом
    $expected_results = file($expected_result_file, FILE_IGNORE_NEW_LINES);

    // Чтение входных данных
    list($n, $m) = array_map('intval', explode(' ', trim(fgets($stdin))));
    $graph = array_fill(0, $n, array_fill(0, $n, 0));

    for ($i = 0; $i < $m; $i++) {
        list($ai, $bi, $wi) = array_map('intval', explode(' ', trim(fgets($stdin))));
        $graph[$ai][$bi] = $wi;
        $graph[$bi][$ai] = $wi;
    }

    $k = intval(trim(fgets($stdin)));
    $queries = [];
    for ($i = 0; $i < $k; $i++) {
        $queries[] = array_map('trim', explode(' ', fgets($stdin)));
    }

  
    fclose($stdin);

  
    $results = processQueries($graph, $queries);
    $passed = true;
    foreach ($results as $index => $result) {
        if ($result != $expected_results[$index]) {
            $passed = false;
            echo "Test $test_name failed! Query index: $index, Expected: {$expected_results[$index]}, Actual: $result\n";
        }
    }

    if ($passed) {
        echo "Test $test_name passed!\n";
    }
}



for ($i = 1; $i <= 9; $i++) {
    $test_name = sprintf("D\\%03d", $i);
    run_test($test_name);
}

?>
