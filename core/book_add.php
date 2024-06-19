<?php
session_start(); // Начинаем сессию, если она ещё не начата
require_once '../core/dbh.php';
require_once '../model/add_book.model.php';

function generateUniqueFileName($prefix, $extension) {
    return $prefix . uniqid() . '.' . $extension;
}



$id_user = $_SESSION['user']['id_user'];
$allow_download = isset($_POST['allow_download']) ? 1 : 0;
$name_book = $_POST['name_book'];
$date_read = date('Y-m-d'); // Пример использования текущей даты

// Обработка загрузки фото книги
$photo_book = $_FILES['photo_book'];
if ($photo_book['error'] === UPLOAD_ERR_OK) {
    $photo_extension = pathinfo($photo_book['name'], PATHINFO_EXTENSION);
    $photo_name = generateUniqueFileName('photo_', $photo_extension);
    $photo_path = '../assets/' . $photo_name;
    if (move_uploaded_file($photo_book['tmp_name'], $photo_path)) {
        $photo_book_db = '/' . $photo_name;
    } else {
        $photo_book_db = null;
    }
} else {
    $photo_book_db = null; // Или можно обработать ошибку
}

// Обработка загрузки файла книги
$file_book = $_FILES['file_book'];
if ($file_book['error'] === UPLOAD_ERR_OK) {
    $file_extension = pathinfo($file_book['name'], PATHINFO_EXTENSION);
    $file_name = generateUniqueFileName('file_', $file_extension);
    $file_path = '../files/' . $file_name;
    if (move_uploaded_file($file_book['tmp_name'], $file_path)) {
        $file_book_db = '/' . $file_name;
    } else {
        $file_book_db = null;
    }
} else {
    $file_book_db = null; // Или можно обработать ошибку
}

// Вызов метода adding из класса AddBook и сохранение данных
$addBook = new AddBook();
$addBook->adding($id_user, $photo_book_db, $date_read, $allow_download, $file_book_db, $name_book);

echo json_encode(array(
    'status' => 'success',
    'message' => "Книга успешно добавлена: Юзер $id_user, Фото: $photo_book_db, Дата: $date_read, Файл: $file_book_db, Разрешение: $allow_download"
));
?>
