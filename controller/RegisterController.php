<?php
// controller/RegisterController.php

include_once "../model/User.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_user = $_POST['login_user'];
    $password = $_POST['password'];

    // Простейшая валидация
    if (empty($login_user) || empty($password)) {
        echo "Please fill in all fields.";
    } else {
        $user = new User();
        $user->register($login_user, $password);
    }
}
?>
