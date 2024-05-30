<?php

include '../core/dbh.php';

class zapros extends Dbh {

public function getUsers() {

    $sql = "SELECT * FROM users";
    $stmt = $this -> connect() -> query($sql);
    return $stmt->fetchAll();

}




}