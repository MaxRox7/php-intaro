<?php

require_once '../core/dbh.php';

class Delete extends Dbh {
    public function deletebook($id_book) {
        $sql = "DELETE FROM book WHERE id_book = :id_book";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':id_book', $id_book, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
