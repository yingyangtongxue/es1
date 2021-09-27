<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;

class configController extends Controller{

    public function __construct() {}

    public static function index($params)
    {
        echo Views::render("template_first_time","", [
            'URL' => '<base href="'.getenv('URL').'">',
            'title' => 'Configurando Projeto'
          ]);
    }

}

