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
       
      
        $userlogin = $stmt->fetch();
        if ($userlogin) {
            session_start();
            $_SESSION['user'] = ['login' => $login , 'password' => $password];
           

            header('Content-Type: application/json');
            echo json_encode(array('status' => 'success', 'id_user' => $userlogin['id_user'])); 
            header('Location: ../view/books.php');
            
        } else {

            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error', 'message' => 'Неверное имя пользователя или пароль.'));
      
        }
    
    }



}