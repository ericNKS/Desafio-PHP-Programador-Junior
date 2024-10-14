<?php
namespace App\Repository;

use App\Database\Connection;
use App\Model\Produto;
class ProdutoRepository
{
    private static $con;

    private static function initConnection()
    {
        if (self::$con === null) {
            self::$con = Connection::conn();
        }
    }

    public static function findAll(){
        self::initConnection();
        $query = '
            SELECT
                *
            FROM
                produtos
        ';
        try {
            $stmt = self::$con->query($query);
            $result = $stmt->fetch_all(MYSQLI_ASSOC);
            return $result;
        } catch (\Throwable $th) {
            return throw $th;
        }
    }

    public static function paginate(int $page, int $itemsPerPage){
        self::initConnection();
        $query = '
            SELECT
                id, name, price, description
            FROM
                (SELECT *, ROW_NUMBER() OVER (ORDER BY id)  as row_num FROM produtos) as temp_table
            WHERE
                row_num > ?
            ORDER BY
                id ASC
            LIMIT
                ?
        ';
        try {
            $stmt = self::$con->prepare( $query );
            $stmt->bind_param('ii', $page, $itemsPerPage);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            return $result;
        } catch (\Throwable $th) {
            return throw $th;
        }
    }

    public static function findById(int $id){
        self::initConnection();
        $query = '
            SELECT
                *
            FROM
                produtos
            WHERE
                id = ?
        ';

        try {
            $stmt = self::$con->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            
            $result = $stmt->get_result()->fetch_assoc();

            if(!$result){
                return false;
            }
            return $result;
        } catch (\Throwable $th) {
            return throw $th;
        }
    }

    public static function findByName(string $name){
        self::initConnection();
        $query = '
            SELECT
                *
            FROM
                produtos
            WHERE
                name LIKE ?
        ';
        $name = '%' . $name . '%';
        try {
            $stmt = self::$con->prepare($query);
            $stmt->bind_param('s', $name);
            $stmt->execute();
            
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            if(!$result){
                return [];
            }
            return $result;
        } catch (\Throwable $th) {
            return throw $th;
        }
    }

    public static function create(Produto $produto){
        self::initConnection();
        $query = '
            INSERT INTO
                produtos(name, description, price)
            VALUES(?, ?, ?)
        ';
        try {
            $name = $produto->getName();
            $description = $produto->getDescription();
            $price = $produto->getPrice();
            $stmt = self::$con->prepare($query);
            $stmt->bind_param('ssd', $name, $description, $price);
            if(!$stmt->execute()) return false;
            return self::findById(self::$con->insert_id);
        } catch (\Throwable $th) {
            return throw $th;
        }
    }

    public static function update(Produto $produto){
        self::initConnection();
        $id = $produto->getId();
        $name = $produto->getName();
        $price = $produto->getPrice();
        $description = $produto->getDescription();
        try {
            $query = '
                UPDATE
                    produtos
                SET
                    name = ?, description = ?, price =?
                WHERE
                    id = ?
            ';
            $stmt = self::$con->prepare($query);
            $stmt->bind_param('ssdi', $name, $description, $price, $id);
            $stmt->execute();
            return [
                'id' => $id,
                'name'=> $name,
                'description'=> $description,
                'price'=> $price,
                'created_at' => $produto->getCreatedAt()
            ];
        } catch (\Throwable $th) {
            return throw $th;
        }
    }

    public static function destroy(Produto $produto){
        self::initConnection();
        $id = $produto->getId();
        try {
            $query = '
                DELETE
                FROM
                    produtos
                WHERE
                    id = ?
            ';
            $stmt = static::$con->prepare($query);
            $stmt->bind_param('i', $id);
            
            return $stmt->execute();
        } catch (\Throwable $th) {
            return throw $th;
        }
        
    }
}