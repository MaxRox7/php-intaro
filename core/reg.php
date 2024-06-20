<?php
require_once 'dbh.php'; // Используйте require_once
require_once '../model/reg.model.php'; // Используйте require_once
require_once '../controller/reg.contr.php'; // Используйте require_once

if(isset($_POST["submit-reg"])) {
    $login = $_POST["login"];
    $password = $_POST["password"];
    $password_repeat = $_POST["reg-confirm-password"];

    echo "Логин: $login, Пароль: $password, Повторите пароль: $password_repeat<br>";

    $signup = new RegContr($login, $password, $password_repeat);
    echo "Объект создан<br>";

    $signup->checkReg();

    $userDataString = json_encode(array('status' => 'success', 'user' => "Красава"));
    header("Location: /lib");
    echo $userDataString;
    exit();
} else {
    $errorDataString = json_encode(array('status' => 'error', 'message' => 'Форма не была отправлена корректно'));
    header('Content-Type: application/json');
    echo $errorDataString;
    exit();
}
?>
