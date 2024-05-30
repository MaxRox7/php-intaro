<?php

if(isset($_POST["submit-reg"])) {

$login = $_POST["login"];
$password = $_POST["password"];
$password_repeat = $_POST["reg-confirm-password"];


echo "$login";

include 'dbh.php';
include "../model/reg.model.php";
include "../controller/reg.contr.php";


$signup = new RegContr($login, $password, $password_repeat);

$reg -> checkReg();

$userDataString = json_encode(array('status' => 'success', 'user' => "Красава"));

header('Content-Type: application/json');
echo $userDataString;
exit();

}