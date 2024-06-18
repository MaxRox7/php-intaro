<?php

require_once '../model/reg.model.php';

class AuthContr extends SignUpAuth {
    private $login;
    private $password;

    public function __construct($login, $password) {
        $this->login = $login;
        $this->password = $password;

        // Отладочный вывод
        echo "Конструктор вызван: Логин: $login, Пароль: $password";
    }

}