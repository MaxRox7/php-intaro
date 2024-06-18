


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <!-- Подключение Materialize CSS через CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Подключение стилей для персонализации -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .card {
            width: 400px;
            padding: 20px;
        }
        .input-field input[type=text], 
        .input-field input[type=password] {
            border-bottom: 1px solid #9e9e9e;
            box-shadow: none;
        }
        .input-field input[type=text]:focus:not([readonly]), 
        .input-field input[type=password]:focus:not([readonly]) {
            border-bottom: 1px solid #2196f3;
            box-shadow: none;
        }
        .input-field input[type=text]:focus:not([readonly])+label, 
        .input-field input[type=password]:focus:not([readonly])+label {
            color: #2196f3;
        }
        .btn-register {
            margin-right: 10px;
        }
        .btn-registration {
            margin-left: 10px;
        }
        .btn-registration {
            margin-top: 10px;
            margin-right: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card">
                    <h3 class="center-align">Авторизация</h3>
                    <form action="core/auth.php" method="post">
                        <div class="input-field">
                            <input id="login" type="text" name="login" required>
                            <label for="login">Логин</label>
                        </div>
                        <div class="input-field">
                            <input id="password" type="password" name="password" required>
                            <label for="password">Пароль</label>
                        </div>
                        <div class="input-field center-align">
                            <button class="btn waves-effect waves-light" type="submit" name="submit-auth">Войти</button>
                            <a href="#" class="btn btn-register waves-effect waves-light">На главную</a>
                            <a href="view/homepage.php" class="btn btn-registration waves-effect waves-light">Регистрация</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Подключение jQuery (необходимо для Materialize) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Подключение Materialize JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
