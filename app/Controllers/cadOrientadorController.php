<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;
use App\Models\User;
use App\Utils\System;

class cadOrientadorController extends Controller{

    public function __construct() {}

    public static function index($params)
    {
      session_start();

      $error = System::errorExists();

      echo Views::render("template_usp","cadOrientador", 
      [
        'URL' => '<base href="'.getenv('URL').'">',
        'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI - Cadastro Orientador'
      ], 
      [
        'error' => $error
      ]);

    }

    public static function cadastrar()
    {
      if (isset($_POST['email']) && isset($_POST['password']))
      {
        User::cadastro('orientador');
      }
      else{
        header('Location: '.getenv('URL') .'cadOrientador');
      }
    }

    public static function getMethods()
    {
      return ["index","cadastrar"];
    }

}

