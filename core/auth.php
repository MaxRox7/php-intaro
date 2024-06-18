<?php


require_once 'dbh.php'; // Используйте require_once
require_once '../model/auth.model.php'; // Используйте require_once
require_once '../controller/auth.contr.php'; // Используйте require_once



if(isset($_POST["submit-auth"])) {


    $login = $_POST["login"];
    $password = $_POST["password"];

    $auth = new AuthContr($login, $password);
    echo "Объект создан<br>";

    $auth->checkUser($login, $password);


    $userDataString = json_encode(array('status' => 'success', 'user' => "Красава"));
    header('Content-Type: application/json');
    echo $userDataString;
    exit();
} else {
    $errorDataString = json_encode(array('status' => 'error', 'message' => 'Форма не была отправлена корректно'));
    header('Content-Type: application/json');
    echo $errorDataString;
    exit();
}
?>

}