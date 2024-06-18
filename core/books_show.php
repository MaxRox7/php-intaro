<?php
session_start();
require_once '../model/query_books.php'; // Используйте require_once

$query = new Zapros();
$books = $query->getbooks(); // Используем метод для получения данных с JOIN

?>

