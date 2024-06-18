<?php
session_start();

if (empty($_SESSION['user'])) {

header('Location: authen.php');
echo "Доступ запрещен";
die;

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>asasas</title>
</head>
<body>
    
<?php   
echo 'Привет, '. $_SESSION['user']['login'];


?>
<a href="../logout.php">Выход</a>
</body>
</html>