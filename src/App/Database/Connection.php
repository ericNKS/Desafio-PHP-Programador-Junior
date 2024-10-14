<?php

namespace App\Database;

use App\Controller\Response;

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
                Response::JSON(['Connection failed' => $this->connection ->connect_error], 500);
                return;
            }
        } catch (\Throwable $th) {
            Response::JSON(['error' => $th->getMessage()], 500);
        }
    }
    public static function conn(){
        $con = new Connection();
        return  $con->connection;
    }
}