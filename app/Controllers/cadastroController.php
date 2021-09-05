<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;

class cadastroController extends Controller{

    public function __construct() {}

    public static function index()
    {
      echo Views::render("template_usp","cadastro", [
        'URL' => '<base href="'.getenv('URL').'">',
        'title' => 'Cadastro'
      ]);
    }

}

