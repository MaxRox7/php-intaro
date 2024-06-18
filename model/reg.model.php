<?php
require_once '../core/dbh.php';

class SignUp extends Dbh {

    protected function checkUser($login, $password) {
        $sql = 'SELECT login_user FROM users WHERE login_user = ? AND password_user = ?';
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt) {
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error', 'message' => 'Ошибка подготовки запроса.'));
            exit();
        }
        $stmt->execute([$login, $password]);
        $userlogin = $stmt->fetch();

        if ($userlogin) {
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error', 'message' => 'Пользователь с таким логином уже существует.'));
            exit();
        }
    }

    public function inputUser($login, $password) {
        $sql = 'INSERT INTO users (login_user, password_user) VALUES (?, ?)';
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt) {
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error', 'message' => 'Ошибка подготовки запроса.'));
            exit();
        }

        $hashedpwd = hash('sha256', $password);
        if (!$stmt->execute([$login, $hashedpwd])) {
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error', 'message' => 'Ошибка при выполнении запроса.'));
            exit();
        }
    }
}
?>