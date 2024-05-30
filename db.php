<?php
// db.php

$dbhost = 'localhost';
$dbname = 'library';
$dbuser = 'user';
$dbpass = '1904';

try {
    $pdo = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>