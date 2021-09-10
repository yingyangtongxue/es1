<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;
use App\Models\Orientador;
use App\Models\User;

class cadastroController extends Controller{

    public function __construct() {}

    public static function index($params)
    {
      echo Views::render("template_usp","cadastro", [
        'URL' => '<base href="'.getenv('URL').'">',
        'title' => 'Cadastro'
      ]);
    }

    public static function cadastrar()
    {
      User::cadastro('orientador');
    }

    public static function getMethods()
    {
      return get_class_methods(get_class());
    }

}

