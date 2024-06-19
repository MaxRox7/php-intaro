<?php

require_once '../core/books_show.php';

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список книг</title>
    <!-- Подключение Materialize CSS через CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Подключение стилей для персонализации -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f0f0f0;
            padding: 20px;
            position: relative;
        }
        .user-info {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            align-items: center;
        }
        .user-info a, .user-info button {
            margin-left: 10px;
        }
        .content {
            width: 100%;
            max-width: 1200px;
            padding-top: 80px; /* Отступ сверху для элементов в правом верхнем углу */
            padding-left: 10px;
            padding-right: 10px;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .card {
            width: 280px; /* Уменьшенный размер карточки */
            margin: 20px;
        }
        .card-image img {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }
        .card-content p {
            margin: 10px 0;
        }
        .edit-link {
            display: block;
            margin-top: 10px;
        }
        .download-link {
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="user-info">
    <?php if (isset($_SESSION['user'])): ?>
        <span><?php echo htmlspecialchars($_SESSION['user']['login']); ?></span>
        <a href="../logout.php">Выход</a>
        <a href="../view/add_book.php" class="btn">Добавить книгу</a>
    <?php else: ?>
        <a href="/lib">Авторизоваться</a>
    <?php endif; ?>
</div>
    <div class="content">
        <div class="row">
            <?php if ($books): ?>
                <?php foreach ($books as $book): ?>
                    <div class="col s12 m6 l4">
                        <div class="card">
                            <div class="card-image">
                                <img src="<?php echo htmlspecialchars('../assets' . $book['photo_book']); ?>" alt="Book Image">
                            </div>
                            <div class="card-content">
                                <p><strong>Пользователь:</strong> <?php echo htmlspecialchars($book['login_user']); ?></p>
                                <p><strong>Название:</strong> <?php echo htmlspecialchars($book['name_book']); ?></p>
                                <?php if ($book['allow_download']): ?>
                                    <a href="<?php echo htmlspecialchars('../files/' . $book['file_book']); ?>" class="download-link">Скачать</a>
                                <?php endif; ?>
                                <?php if (isset($_SESSION['user'])): ?>
                                    <a href="#" class="edit-link">Редактировать</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Нет данных для отображения.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Подключение jQuery (необходимо для Materialize) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Подключение Materialize JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
