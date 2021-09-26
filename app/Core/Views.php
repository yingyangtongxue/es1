<?php

namespace App\Core;

class Views{

    public function __construct(){}

    public static function getTemplate($template){
        $file = __DIR__."/../Resources/views/templates/".$template.".html";
        return file_exists($file) ? file_get_contents($file) : "";
    }

    public static function getContentView($view, $vars = []){
        $file = __DIR__."/../Resources/views/pages/".$view.".html";
        if (file_exists($file))
        {
            $content = file_get_contents($file);
        } 
        else return "";
        
        $keys = array_keys($vars);
        $keys = array_map(function($item){
            return '{{'.$item.'}}';
        },$keys);

        return str_replace($keys, array_values($vars), $content);
    }

    public static function render($template, $view, $vars = [], $contentVars = []){
        $template = self::getTemplate($template);
        $contentView = self::getContentView($view, $contentVars);


        $vars['content'] = $contentView;
    
        $keys = array_keys($vars);
        $keys = array_map(function($item){
            return '{{'.$item.'}}';
        },$keys);

        return str_replace($keys, array_values($vars), $template);
    }
}

