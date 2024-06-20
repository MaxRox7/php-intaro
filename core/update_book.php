<?php

require_once '../core/dbh.php';
require_once '../model/spec_book.model.php';

session_start();


if (isset($_POST['id_book'])) {
    $id_book = $_POST['id_book'];
    $name_book = $_POST['name_book'];
    $allow_download = isset($_POST['allow_download']) ? 1 : 0; // Проверяем, был ли установлен чекбокс

    // Проверяем и загружаем новое фото книги
    if ($_FILES['photo_book']['error'] === UPLOAD_ERR_OK) {
        $photo_book = 'photo_' . uniqid() . '_' . $_FILES['photo_book']['name'];
        move_uploaded_file($_FILES['photo_book']['tmp_name'], '../assets' . $photo_book);
    } else {
        $photo_book = ''; // Если не загрузилось новое, оставляем старое
    }

    // Проверяем и загружаем новый файл книги
    if ($_FILES['file_book']['error'] === UPLOAD_ERR_OK) {
        $file_book = 'file_' . uniqid() . '_' . $_FILES['file_book']['name'];
        move_uploaded_file($_FILES['file_book']['tmp_name'], '../files/' . $file_book);
    } else {
        $file_book = ''; // Если не загрузился новый, оставляем старый
    }

    $update = new Spec();
    $result = $update->updatebook($id_book, $name_book, $photo_book, $allow_download, $file_book);

    if ($result) {
        header("Location: /lib/view/books.php"); // Перенаправляем на главную страницу после обновления
        exit();
    } else {
        echo "Ошибка при обновлении книги.";
    }
} else {
    echo "Неверный запрос.";
}
?>


