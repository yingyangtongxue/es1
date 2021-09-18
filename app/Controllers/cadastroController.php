<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;
use App\Models\User;
use App\Utils\Errors\System;

class cadastroController extends Controller{

    public function __construct() {}

    public static function index($params)
    {
      $page =  Views::render("template_usp","cadastro", [
        'URL' => '<base href="'.getenv('URL').'">',
        'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI - Cadastro'
      ]);

      $error = System::errorExists();

      echo str_replace('{{error}}', $error, $page);
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

