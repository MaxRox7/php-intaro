<?php

require_once '../core/dbh.php';

class Spec extends Dbh {

    public function getspecbook($id_book) {
        $sql = "SELECT photo_book, name_book, file_book, allow_download, id_book
                FROM book
                WHERE id_book = :id_book";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id_book', $id_book, PDO::PARAM_INT);
        $stmt->execute(); // Выполняем запрос

        // Используем fetch() для получения одной строки результата
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        return $book;
    }
   
    public function updatebook($id_book, $name_book, $photo_book, $allow_download, $file_book) {
        $sql = "UPDATE book SET name_book = :name_book, photo_book = :photo_book, allow_download = :allow_download, file_book = :file_book WHERE id_book = :id_book";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id_book', $id_book, PDO::PARAM_INT);
        $stmt->bindParam(':name_book', $name_book, PDO::PARAM_STR);
        $stmt->bindParam(':photo_book', $photo_book, PDO::PARAM_STR);
        $stmt->bindParam(':allow_download', $allow_download, PDO::PARAM_BOOL);
        $stmt->bindParam(':file_book', $file_book, PDO::PARAM_STR);
        return $stmt->execute();
    }
    }

