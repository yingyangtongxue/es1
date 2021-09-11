<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;

class homeController extends Controller{

    public function __construct() {}

    public static function index($params)
    {
        echo Views::render("template_usp","home", [
            'URL' => '<base href="'.getenv('URL').'">',
            'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI'
          ]);
    }

}

