<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
    <form action="core/reg.php" method="post">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="password" name="reg-confirm-password" placeholder="Повторите пароль" required>
        <input type="submit" name="submit-reg" value="Зарегистрироваться">
    </form>
</body>
</html>
