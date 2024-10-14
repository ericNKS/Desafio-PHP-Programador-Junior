<?php
namespace App\Controller;

class WordController
{
    public static function countUniqueWords(string $text){
        $textWithoutSignal = preg_replace('/[^\w\s]/u', '', $text);
        
        $textWithoutSignal = strtolower($textWithoutSignal);
        $textSplited = explode(' ', $textWithoutSignal);
        $uniqueWords = [
            'count' => 0,
            'words' => []
        ];
        foreach($textSplited as $word){
            if(!isset($uniqueWords['words'][$word])){
                $uniqueWords['words'][$word] = 1;
                continue;
            }
            $uniqueWords['words'][$word] ++;
        }
    
        $uniqueWords['count'] = count($uniqueWords['words']);
    
        return $uniqueWords;
    }
}