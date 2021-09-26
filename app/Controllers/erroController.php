<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;

class erroController extends Controller{

    public function __construct() {}

    public static function index($error)
    {

      $error = $error[0];
      if(!isset($error) || empty($error) ||$error == null) $error = '404';
      else if($error != "404" && $error != "403") $error = '404';
       
      echo Views::render("template_erro","error{$error}", [
        'URL' => '<base href="'.getenv('URL').'">',
        'title' => "{$error} | Erro"
      ]);
    }

}
