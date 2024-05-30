
<?php      
include '../model/zapros.php';



// Пример использования класса Dbh
$dbh = new zapros();
// print_r ($dbh->getUsers());
// // // Вывод массива пользователей
// // echo '<pre>';
// // print_r($users);
// // echo '</pre>';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorization and Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form auth-form">
                <h2>Авторизация</h2>
                <form action = '../core/auth.php'  method="post">
                    <label for="login">Логин</label>
                    <input type="login" id="login" name="login" required>
                    <label for="auth-password">Пароль:</label>
                    <input type="password" id="auth-password" name="auth-password" required>
                    <button type="submit-log">Войти</button>
                </form>
            </div>
            <div class="form reg-form">

            <button class="guest-login">Войти без авторизации</button>
            
            
            <h2>Регистрация</h2>
                <form action = '../core/reg.php' method="post">
                    <label for="login-reg">Логин</label>
                    <input type="login-reg" id="login-reg" name="login-reg" required>
                    <label for="reg-password">Пароль:</label>
                    <input type="password" id="reg-password" name="reg-password" required>
                    <label for="reg-confirm-password">Подтвердите пароль:</label>
                    <input type="password" id="reg-confirm-password" name="reg-confirm-password" required>
                    <button type="submit-reg">Зарегистрироваться</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
