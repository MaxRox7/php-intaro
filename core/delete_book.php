<?php

require_once '../core/dbh.php';
require_once '../model/query_delete.model.php';

session_start();

if (isset($_SESSION['user']['id_user']) && isset($_POST['id_book'])) {
   
    $id_book = $_POST['id_book'];

    $delete = new Delete();
    $result = $delete->deletebook($id_book);

    if ($result) {
        header("Location: /lib/view/books.php"); // Перенаправление на главную страницу после удаления
    } else {
        echo "Ошибка при удалении книги.";
    }
} else {
    echo "Неверный запрос.";
}
?>
