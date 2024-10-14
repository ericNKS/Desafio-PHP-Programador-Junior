<?php
namespace App\Controller;

use App\Model\Produto;
use App\Repository\ProdutoRepository;
use App\Service\ProdutoService;

class ProdutoController
{
    public static function index(){
        try {
            $result = ProdutoRepository::findAll();

            Response::JSON($result);
            return;
        } catch (\Throwable $th) {
            Response::JSON(["error"=> $th->getMessage(), 500]);
            return;
        }
    }

    public static function getPaginatedProducts(int $page, int $limit){
        $page = max(1, intval($page));
        $limit = max(1, intval($limit));
        $cursorPage = ($page - 1) * $limit;

        try{
            $data = ProdutoRepository::paginate($cursorPage, $limit);
            
            $next = $page;
            if(count($data) - 1 > 0){
                $next++;
            }
            $prev = $page;
            if($page > 1){
                $prev --;
            }

            $links = [
                'prev' => "/produto?page=$prev&limit=$limit",
                'next' => "/produto?page=$next&limit=$limit"
            ];
            
            $result = [
                'links' => $links,
                'data' => $data
            ];
            Response::JSON($result);
            return;
        }catch (\Throwable $th) {
            Response::JSON(["error"=> $th->getMessage(), 500]);
            return;
        }
    }

    public static function search($name){

        try {
            $result = ProdutoRepository::findByName($name);

            Response::JSON($result);
            return;
        } catch (\Throwable $th) {
            Response::JSON(["error"=> $th->getMessage(), 500]);
            return;
        }
    }

    public static function update(int $id, array $body){
        try {
            $produto = ProdutoService::update($id, $body);
            Response::JSON(['succes' => $produto]);
            return;
        } catch (\Throwable $th) {
            Response::JSON(["error"=> $th->getMessage(), 500]);
        }
    }

    public static function store($body){
        try {
            $produto = ProdutoService::create($body);

            Response::JSON($produto);
            return;
        } catch (\Throwable $th) {
            Response::JSON(["error"=> $th->getMessage(), 500]);
        }
    }

    public static function destroy(int $id){
        try {
            $wasDeleted = ProdutoService::destroy($id);

            Response::JSON([], 204);
            return;
        } catch (\Throwable $th) {
            Response::JSON(["error"=> $th->getMessage()], 500);
        }
    }
}