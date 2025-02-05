<?php

class Connect{
    private $host = 'localhost';
    private $dbName = 'new_app';
    private $username = 'root';
    private $password = '';
    private $pdo;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset=utf8";
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getPDO() {
        return $this->pdo;
    }
}