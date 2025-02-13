<?php

class Connect{
    private $host = 'mysql1017.onamae.ne.jp';
    private $dbName = '0eq3a_new_app';
    private $username = '0eq3a_yuitns';
    private $password = 'Y2621031h!';
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