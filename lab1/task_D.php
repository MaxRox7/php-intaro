<?php

// Функция для поиска кратчайшего пути в графе с помощью алгоритма Дейкстры
function dijkstra($graph, $source, $destination) {
    $INF = PHP_INT_MAX;
    $n = count($graph);
    $visited = array_fill(0, $n, false);
    $distances = array_fill(0, $n, $INF);
    $distances[$source] = 0;
    
    for ($i = 0; $i < $n - 1; $i++) {
        $minDist = $INF;
        $minIndex = -1;
        
        for ($j = 0; $j < $n; $j++) {
            if (!$visited[$j] && $distances[$j] < $minDist) {
                $minDist = $distances[$j];
                $minIndex = $j;
            }
        }
        
        $visited[$minIndex] = true;
        
        for ($j = 0; $j < $n; $j++) {
            if (!$visited[$j] && $graph[$minIndex][$j] && $distances[$minIndex] != $INF && $distances[$minIndex] + $graph[$minIndex][$j] < $distances[$j]) {
                $distances[$j] = $distances[$minIndex] + $graph[$minIndex][$j];
            }
        }
    }
    
    return ($distances[$destination] == $INF) ? -1 : $distances[$destination];
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

// Чтение входных данных
$stdin = fopen('tests/D/005.dat', 'r');
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

// Обработка запросов и вывод результатов
$results = processQueries($graph, $queries);
foreach ($results as $result) {
    echo $result . PHP_EOL;
}

fclose($stdin);
?>
