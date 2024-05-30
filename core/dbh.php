<?php

class Dbh
{
    private $db_host = 'localhost';
    private $db_name = 'library';
    private $db_user = 'postgres';
    private $db_pass = '1904';
    private $db;
    private $db_port = '5432';

    public function __construct()
    {
        $this->db = $this->connect();
    }

    protected function connect()
    {
        try {
            $dsn = 'pgsql:host=' . $this->db_host . ';port=' . $this->db_port . ';dbname=' . $this->db_name;

            $db = new PDO($dsn, $this->db_user, $this->db_pass);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Ошибка подключения к БД: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Ошибка: ' . $e->getMessage());
        }
        return $db;
    }
    
}
