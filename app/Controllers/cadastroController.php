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
        'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI - Cadastro'
      ]);
    }

    public static function cadastrar()
    {
      if (isset($_POST['email']) && isset($_POST['password']))
      {
        User::cadastro('orientador');
      }
      else{
        header('Location: '.getenv('URL') .'cadastro');
      }
    }

    public static function getMethods()
    {
      return get_class_methods(get_class());
    }

}

