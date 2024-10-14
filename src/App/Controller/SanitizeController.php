<?php
namespace App\Controller;

class SanitizeController
{

    public static function sanitizeInput($input, string $type){
        switch( strtolower($type) ){
            case 'string':
                $newInput = trim($input);
                $newInput = stripslashes($newInput);
                $newInput = htmlspecialchars($newInput, ENT_QUOTES, 'UTF-8');

                Response::JSON(['success' => $newInput]);
                break;
            case 'inteiro':
                if(!filter_var($input, FILTER_VALIDATE_INT)){
                    Response::JSON(['error' => 'input is not a integer'], 400);
                    return;
                }

                echo intval($input);
                break;
            case 'email':
                if(!filter_var( $input, FILTER_VALIDATE_EMAIL)){
                    Response::JSON(['error' => 'input is not a email'], 400);
                    break;
                }
                Response::JSON(['success' => $input]);
                break;
            case 'url':
                if(!filter_var( $input, FILTER_VALIDATE_URL)){
                    Response::JSON(['error' => 'input is not a URL'], 400);
                    break;
                }
                Response::JSON(['success' => $input]);
                break;
            default:
                Response::JSON(['error' => 'type not valid'], 400);
                break;
        }
    }
}