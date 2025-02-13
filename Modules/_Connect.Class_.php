<?php



class Connect{

    private $host = 'dpg-cuhij6dumphs73fkklk0-a.oregon-postgres.render.com';

    private $dbName = 'new_app_nv47';

    private $username = 'allusers';

    private $password = 'LCXYPDv1LucG2lMNuxK884C9L8S36XJ7';

    private $connection;



    public function __construct() {

        $connectionString = "host={$this->host} dbname={$this->dbName} user={$this->username} password={$this->password} sslmode=require";

        $this->connection = pg_connect($connectionString);



        if (!$this->connection) {

            die("Connection failed: " . pg_last_error());

        }

    }

}

