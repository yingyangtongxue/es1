<?php

namespace App\Controllers;

use App\Core\Controller;


class erroController extends Controller{

    public function __construct() {}

    public static function index()
    {
      echo 'Erro: Página não encontrada';
    }

}

?>
