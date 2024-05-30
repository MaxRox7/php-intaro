<?php
// view/register.php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <h1>Registration Form</h1>
    <form action=".http://localhost:880/buba/controller/RegisterController.php" method="post">
        <label for="login_user">login_user:</label>
        <input type="text" id="login_user" name="login_user" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="submit">
    </form>
</body>
</html>
