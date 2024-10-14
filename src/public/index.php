<?php

use App\Controller\ProdutoController;
use App\Controller\Response;
use App\Controller\SanitizeController;
use App\Controller\WordController;

require __DIR__ . '/../vendor/autoload.php';

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$controllerDir = 'Controller/';
$app = __DIR__ . '/../App/';

switch (true) {
    case $request === '/produto' && isset($_GET['page']) && isset($_GET['limit']) && $_SERVER['REQUEST_METHOD'] === 'GET':
        $page = intval($_GET['page']);
        $limit = intval($_GET['limit']);
        ProdutoController::getPaginatedProducts($page, $limit);
        break;

    case $request === '/produto' && isset($_GET['item']) && $_SERVER['REQUEST_METHOD'] === 'GET':
        $nome = urldecode($_GET['item']);
        ProdutoController::search($nome);
        break;
        
    case $request === '/produto' && $_SERVER['REQUEST_METHOD'] === 'GET':
        ProdutoController::index();
        break;

    case $request === '/produto' && $_SERVER['REQUEST_METHOD'] === 'POST':
        $body = json_decode(file_get_contents('php://input'), true);
        ProdutoController::store($body);
        break;

    case $request === '/produto' && isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'PUT':
        $id = $_GET['id'];
        $body = json_decode(file_get_contents('php://input'), true);
        ProdutoController::update($id, $body);
        break;

    case $request === '/produto' && isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'DELETE':
        $id = $_GET['id'];
        ProdutoController::destroy($id);
        break;
        
    case $request === '/sanitize' && isset($_GET['input']) && isset($_GET['type']) && $_SERVER['REQUEST_METHOD'] === 'GET':
        $input = $_GET['input'];
        $type = $_GET['type'];
        
        SanitizeController::sanitizeInput($input, $type);
        break;

    case $request === '/sanitize' && $_SERVER['REQUEST_METHOD'] === 'POST':
        $body = json_decode(file_get_contents('php://input'), true);

        if(!isset($body['input']) || !isset($body['type'])){
            Response::JSON(['error' => 'input and type is required'], 400);
            return;
        }

        $input = $body['input'];
        $type = $body['type'];
        
        SanitizeController::sanitizeInput($input, $type);
        break;
    
    case $request === '/unique' && $_SERVER['REQUEST_METHOD'] === 'GET':
        echo '<pre>';
        print_r(WordController::countUniqueWords('Hello world! Hello people'));
        echo '</pre>';
        break;

    default:
        http_response_code(404);
        require $app . 'View/404.php';
}

