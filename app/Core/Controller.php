<?php

namespace App\Core;

class Controller{

    public function __construct() {}

    public static function index($params){}

    public static function getMethods(){
        return get_class_methods(get_class());
    }
  
}


