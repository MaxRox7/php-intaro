<?php

require_once '../core/dbh.php';

class Zapros extends Dbh {

public function getbooks() {

    $sql = "SELECT book.photo_book, book.date_read, users.login_user
    FROM book
    JOIN users ON book.id_user = users.id_user";
    $stmt = $this -> connect() -> query($sql);
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $books;

}


}