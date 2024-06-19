<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить книгу</title>
    <!-- Подключение Materialize CSS через CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
    label.active {
            margin-top: -10px; /* Пример отступа сверху */
            padding-bottom: 5px; /* Пример отступа снизу */
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .form-container {
            width: 400px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container label {
            font-weight: bold;
        }
        .form-container .input-field {
            margin-bottom: 30px; /* Увеличенные отступы */
        }
        .form-container input[type="submit"] {
            width: 100%;
        }

        .input-field span {
        margin-top:15px;
    }



    </style>
</head>
<body>
    <div class="form-container">
        <form action="../core/book_add.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_user" value="1"> <!-- Пример, замените на ваш способ получения ID пользователя -->
            
            <div class="input-field">
                <input type="text" name="name_book" id="name_book" class="validate" required>
                <label for="name_book" class="active">Название книги:</label>
            </div>
            
            <div class="input-field">
                <input type="file" name="photo_book" id="photo_book" accept="image/*" class="validate">
                <label for="photo_book" class="active">Фото книги:</label>
            </div>
            
            <div class="input-field">
                <label for="allow_download">
                    <input type="checkbox" name="allow_download" id="allow_download">
                    <span>Разрешить скачивание</span>
                </label>
            </div>
            
            <div class="input-field">
                <input type="file" name="file_book" id="file_book" accept="application/pdf" class="validate">
                <label for="file_book" class="active">Файл книги:</label>
            </div>
            
            <div class="input-field">
                <input type="submit" value="Загрузить" class="btn waves-effect waves-light">
            </div>
        </form>
    </div>
    
    <!-- Подключение jQuery (необходимо для Materialize) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Подключение Materialize JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
