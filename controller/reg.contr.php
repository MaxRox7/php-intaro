<?php

include '../model/reg.model.php';


class RegContr extends SignUp {

private $login;
private $password;
private $password_repeat;

public function __construct($login, $password, $password_repeat) {

$this -> login = $login;
$this -> password = $password;
$this -> password_repeat = $password_repeat;
}



public function checkReg() {

if ($this ->emptyInput() == false ) {
    echo json_encode("Иди отсюда");
    exit();



}
if ($this ->checkpwd() == false ) {
    echo json_encode("Иди отсюда");
    exit();



}
if ($this ->checklogin() == false ) {
    echo json_encode("Иди отсюда");
    exit();



}

$this ->inputUser($this -> login,$this -> password, $this ->password_repeat );

}


private function emptyInput() {

    $result;

    if( empty($this -> login) &&  empty($this -> password)  &&  empty($this -> password_repeat) )    {

        $result = false;
        echo json_encode(array('status' => 'error', 'message' => 'Заполните все обязательные поля'));
        exit();
    }

else {
    $result = true;

}

return $result;

}

private function checkpwd() {
$result;
    if ($this -> password == $this -> password_repeat) {

        $result = true;

    }
else {
    $result = false;
    echo json_encode(array('status' => 'error', 'message' => 'Пароли не совпадают'));
    exit();

}
return $result;

}


private function checklogin() {

    if (!$this -> checkUser($this -> login, $this -> password)) {

        $result = true;

    }
else {
    $result = false;
    echo json_encode(array('status' => 'error', 'message' => 'Такой логин уже есть'));
    exit();

}
return $result;


}




}