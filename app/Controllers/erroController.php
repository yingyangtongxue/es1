<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;

class erroController extends Controller{

    public function __construct() {}

    public static function index()
    {
      echo Views::render("template_erro","", [
        'URL' => '<base href="'.getenv('URL').'">',
        'title' => '404 | Erro'
      ]);
    }

}
