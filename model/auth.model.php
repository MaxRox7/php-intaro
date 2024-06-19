<?php
require_once '../core/dbh.php';

class SignUpAuth extends Dbh {

    public function checkUser($login, $password) {
        $sql = 'SELECT * FROM users WHERE login_user = ? AND password_user = ?';
       
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$login, hash('sha256', $password)]);

        if (!$stmt) {
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error', 'message' => 'Ошибка подготовки запроса.'));
            exit();
        }
       
        $user = $stmt->fetch(); // Извлекаем результат запроса

        if ($user) {
            session_start();
            $_SESSION['user'] = [
                'id_user' => $user['id_user'], // Сохраняем id_user в сессию
                'login' => $login,
                'password' => $password
            ];

            header('Content-Type: application/json');
            echo json_encode(array('status' => 'success', 'id_user' => $user['id_user'])); 
            header('Location: ../view/books.php');
            exit(); // Важно завершить выполнение после редиректа
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error', 'message' => 'Неверное имя пользователя или пароль.'));
        }
    }
}
?>
