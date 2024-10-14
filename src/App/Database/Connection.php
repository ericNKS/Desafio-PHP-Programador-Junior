<?php

namespace App\Database;

class Connection
{
    private $connection;
    public function __construct(){
        $dbHost = getenv('DB_HOST');
        $dbUser = getenv('DB_USER');
        $dbPass = getenv('DB_PASS');
        $dbName = getenv('DB_NAME');
        try {
            $this->connection = new \mysqli($dbHost, $dbUser, $dbPass, $dbName);

            if ($this->connection->connect_error) {
                throw new \Exception('Connection failed'. $this->connection->connect_error);
                return;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public static function conn(){
        $con = new Connection();
        return  $con->connection;
    }
}