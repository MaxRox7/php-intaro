<?php

require_once '../model/reg.model.php';

class RegContr extends SignUp {
    private $login;
    private $password;
    private $password_repeat;

    public function __construct($login, $password, $password_repeat) {
        $this->login = $login;
        $this->password = $password;
        $this->password_repeat = $password_repeat;

        // Отладочный вывод
        echo "Конструктор вызван: Логин: $login, Пароль: $password, Повторите пароль: $password_repeat<br>";
    }

    public function checkReg() {
        if ($this->emptyInput() == false) {
            echo json_encode(array('status' => 'error', 'message' => 'Заполните все обязательные поля'));
            exit();
        }
        if ($this->checkPwd() == false) {
            echo json_encode(array('status' => 'error', 'message' => 'Пароли не совпадают'));
            exit();
        }
        if ($this->checkLogin() == false) {
            echo json_encode(array('status' => 'error', 'message' => 'Такой логин уже есть'));
            exit();
        }

        $this->inputUser($this->login, $this->password);
        echo json_encode(array('status' => 'success', 'message' => 'Регистрация прошла успешно'));
    }

    private function emptyInput() {
        return !(empty($this->login) || empty($this->password) || empty($this->password_repeat));
    }

    private function checkPwd() {
        return $this->password === $this->password_repeat;
    }

    private function checkLogin() {
        return !$this->checkUser($this->login, $this->password);
    }
}
?>
