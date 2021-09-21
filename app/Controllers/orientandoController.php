<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;

class orientandoController extends Controller{

    public function __construct() {}

    private static function checkSession(){
        if($_SESSION['userType'] == "Orientando"){ return;}
        else header('Location: '.getenv('URL') .'erro404');
    }

    public static function index($params)
    {
        session_start();

        self::checkSession();
        
        $page = Views::render("template_administrativo","", [
            'URL' => '<base href="'.getenv('URL').'">',
            'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI - Orientando',
            'userType' => 'Orientando',
            'userName' => $_SESSION['userName'],
            'menu' => Views::getContentView('menus/menu_orientando')
          ]);

        echo $page;
    }

    public static function getMethods()
    {
        return ["index"];
    }

}