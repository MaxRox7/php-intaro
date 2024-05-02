<?php
try {
    // Подключение к базе данных
    $db = new PDO('pgsql:host=localhost;dbname=add_task2', 'postgres', '1904');
    
    // Установка режима обработки ошибок
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL-запрос для выборки всех записей из таблицы news
    $stmt = $db->query('SELECT id_site, site FROM news');
    
    // Обработка каждой строки результата
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $oldURL = $row['site'];
        
        // Применение регулярного выражения
        preg_match("/\d+-\d/", $oldURL, $matches);
        
        // Создание нового URL
        $newURL = "https://sozd.duma.gov.ru/bill/" . implode("", $matches);
        
        // SQL-запрос для обновления строки в базе данных с новым URL
        $updateStmt = $db->prepare('UPDATE news SET site = :new_url WHERE id_site = :id_site');
        $updateStmt->bindParam(':new_url', $newURL);
        $updateStmt->bindParam(':id_site', $row['id_site']);
        $updateStmt->execute();
    }
    
    echo "Successfully updated URLs.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
