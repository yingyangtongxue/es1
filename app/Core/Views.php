<?php

namespace App\Core;

class Views{

    public function __construct(){}

    public static function getTemplate($template){
        $file = __DIR__."/../Resources/views/templates/".$template.".html";
        return file_exists($file) ? file_get_contents($file) : "";
    }

    public static function getContentView($view){
        $file = __DIR__."/../Resources/views/pages/".$view.".html";
        return file_exists($file) ? file_get_contents($file) : "";
    }

    public static function render($template, $view, $vars = []){
        $template = self::getTemplate($template);
        $contentView = self::getContentView($view);


        $vars['content'] = $contentView;
    
        $keys = array_keys($vars);
        $keys = array_map(function($item){
            return '{{'.$item.'}}';
        },$keys);

        return str_replace($keys, array_values($vars), $template);
    }

}

