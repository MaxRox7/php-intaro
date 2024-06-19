<?php

require_once '../core/dbh.php';



class Book   {

public $id_user;
public $photo_book;
public $date_read;
public $allow;
public $file;
public $name;


public function __construct($id_user, $photo_book, $date_read, $file, $name) {
    $this->id_user = $id_user;
    $this->photo_book = $photo_book;
    $this->date_read = $date_read;
    $this->$file = $file;
    $this->name = $name;
    // Отладочный вывод
    echo "Конструктор вызван: Юзер $id_user, Фото: $photo_book, Дата: $date_read, Файл: $file, $name";
}







}




?>