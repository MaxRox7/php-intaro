<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 


$pdo = new PDO("pgsql:host=localhost;dbname=task_3", "postgres", "1904");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $second_name = $_POST["second_name"];
    $third_name = $_POST["third_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    
    $date_now = date("Y-m-d H:i:s");

    // Проверка входных данных
    if (!preg_match("/^[А-Яа-яЁё\s-]{2,}$/u", $first_name)) {
        echo "Ошибка: Неверный формат имени.";
        exit;
    }

    if (!preg_match("/^[А-Яа-яЁё\s-]{2,}$/u", $second_name)) {
        echo "Ошибка: Неверный формат фамилии.";
        exit;
    }

    if (!empty($third_name) && !preg_match("/^[А-Яа-яЁё\s-]{2,}$/u", $third_name)) {
        echo "Ошибка: Неверный формат отчество.";
        exit;
    }



    if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9_]{3,29}@[a-zA-Z]{2,30}\.[a-z]{2,10}$/', $email)) {
        echo "Ошибка: Неверный формат почты.";
        exit;
    }

    $phone = preg_replace('#[^0-9+]+#uis', '', $phone);
    if (!preg_match('#^(?:\\+?7|8|)(.*?)$#uis', $phone, $m)){
         echo "Ошибка: Неверный формат номера телефона.";
         exit;
    }

    $phone = '+7' . preg_replace('#[^0-9]+#uis', '', $m[1]);
    if (!preg_match('#^\\+7[0-9]{10}$#uis', $phone, $m)){ 
        echo "Ошибка: Неверный формат номера телефона.";
        exit;
    }

    $sql_check = $pdo->prepare("SELECT date_now FROM reviews WHERE email = :email AND date_now < (NOW() - INTERVAL '1 hour')");
    $sql_check->bindParam(':email', $email);
    $sql_check->execute();

    
    $sql_interval = $pdo ->prepare("SELECT date_now FROM reviews WHERE email = :email AND date_now < (NOW() - INTERVAL '1 hour') ORDER BY date_now DESC LIMIT 1;
    ");
    $sql_interval->bindParam(':email', $email);
    $sql_interval->execute();

    $last_date_now = $sql_interval->fetchColumn();

    $last_date_now = strtotime($last_date_now);
    $date_now = strtotime($date_now);
    $difference = $date_now - $last_date_now;
    $hour = 60 - round($difference / 60);
    
    $count = $sql_check->rowCount();
    echo "Найдено {$count} записей. ";
    
    if ($count > 0 && $hour > 0) {


            echo " Вы уже отправляли отзыв. Попробуйте отправить отзыв через ". $hour . " минут";
    
                exit;
 
    }
        
        
    else {
    $date_now = date("Y-m-d H:i:s");
    $insert_stmt = $pdo->prepare("INSERT INTO reviews (first_name, second_name, third_name, email, phone, date_now) VALUES (?, ?, ?, ?, ?, ?)");
    $insert_stmt->execute([$first_name, $second_name, $third_name, $email, $phone, $date_now]);

    
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
       
        $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true;  // authentication enabled
        $mail->isSMTP();
        $mail->Host = 'ssl://smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = 'maximwork19@gmail.com';
        $mail->Password = 'uvrwkhhpxolxchlg';

        $mail->CharSet = 'UTF-8'; 
        $mail->Encoding = 'base64'; // Установка метода 
        $mail->setFrom('maximwork19@gmail.com'); // Ваш адрес электронной почты и имя
        $mail->addAddress("$email"); // Адрес получателя и имя

      
        $mail->isHTML(true);
        $mail->Subject = 'Новая заявка на отзыв';
        $mail->Body = "Имя: $first_name<br>Фамилия: $second_name<br>Отчество: $third_name<br>Email: $email<br>Телефон: $phone";

      
        $mail->send();

       
        echo "Отзыв успешно отправлен и сохранен в базе данных.";


        $next_submission_time = date("H:i:s d.m.Y", strtotime("$date_now +1 hour"));
        echo "<br>С Вами свяжутся после " . date("H:i:s d.m.Y", strtotime("$date_now +1.5 hours"));

    } catch (Exception $e) {
        
        echo "Ошибка при отправке письма: {$mail->ErrorInfo}";
    }
}
}
?>
