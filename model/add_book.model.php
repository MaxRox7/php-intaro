<?php

require_once '../core/dbh.php';

class AddBook extends Dbh {

    public function adding($id_user, $photo_book, $date_read, $allow, $file, $name_book) {
        $sql = "INSERT INTO book (id_user, photo_book, date_read, allow_download, file_book, name_book) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt) {
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error', 'message' => 'Ошибка подготовки запроса.'));
            exit();
        }

        if (!$stmt->execute([$id_user, $photo_book, $date_read, $allow, $file, $name_book])) {
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error', 'message' => 'Ошибка при выполнении запроса.'));
            exit();
        }
    }
}
?>
