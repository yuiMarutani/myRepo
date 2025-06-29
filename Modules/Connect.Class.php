<?php



class Connect{

    //ダミーデータ
    private $host = 'somehostname';

    private $dbName = 'somedatabasename';

    private $username = 'someones';

    private $password = 'somepassword';

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