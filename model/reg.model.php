<?php
include '../core/dbh.php';


class SignUp extends Dbh {

protected function checkUser($login, $password) {
    $sql = 'SELECT login_user FROM users WHERE login_user = ? OR password_user = ?';
    $stmt = $this -> connect() -> prepare($sql);
    $stmtemail->execute([$login]);
    $userlogin = $stmtemail->fetch();

    if ($userlogin) {

        header('Content-Type: application/json');
        echo json_encode(array('status' => 'error', 'message' => 'Пользователь с таким логином уже существует.'));
        exit();

    }

}


public function inputUser($login, $password) {

    $sql = 'INSERT INTO users (login_user, password_user) VALUES (?, ?)';
    $stmt = $this -> connect() -> prepare($sql);
   
    $hashedpwd = hash('sha256', $password);
   



   }




}





    // if (!$stmt ->execute(array($login, $password))) {

    //     $stmt = null;
    //     header("location: ../error");
    //     echo "error";
    //     exit();



    // }