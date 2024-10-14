<?php
namespace App\Service;

use App\Model\Produto;
use App\Repository\ProdutoRepository;

class ProdutoService
{
    private static function validate(array $data){
        if(!isset($data['name']) || empty($data['name'])){
            return throw new \Exception("produto name cannot be empty");
        }
        if(!isset($data['price'])){
            return throw new \Exception("the price cannot be empty");
        }
        if(!is_numeric($data['price'])){
            return throw new \Exception("the price needed be a number");
        }
        if($data['price'] <= 0){
            return throw new \Exception("the price of the product cannot be less than or equal to 0");
        }
        if(!isset($data['description'])){
            $data['description'] = '';
        }

        $produto = new Produto();

        if(isset($data['id'])){
            $produto->setId($data['id']);
        }

        if(isset($data['created_at'])){
            $produto->setCreatedAt($data['created_at']);
        }
        
        $produto->setName($data['name']);
        $produto->setPrice(doubleval($data['price']));
        $produto->setDescription($data['description']);

        return $produto;
    }
    public static function create(array $data){
        try {
            $produto = self::validate($data);

            return ProdutoRepository::create($produto);
        } catch (\Throwable $th) {
            return throw $th;
        }
    }

    public static function destroy(int $id){
        try {
            $produto = self::validate(ProdutoRepository::findById($id));
        } catch (\Throwable $th) {
            return throw new \Exception('produto not exists');
        }

        try {
            return ProdutoRepository::destroy($produto);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public static function update(int $id, array $data){
        try {
            $produto = self::validate(ProdutoRepository::findById($id));

            if(isset($data['name']) && !empty($data['name'])){
                $produto->setName($data['name']);
            }
    
            if(isset($data['price']) && !empty($data['price'])){
                $produto->setPrice($data['price']);
            }
    
            if(isset($data['description']) && !empty($data['description'])){
                $produto->setDescription($data['description']);
            }

            return ProdutoRepository::update($produto);

        } catch (\Throwable $th) {
            return throw $th;
        }
    }

}