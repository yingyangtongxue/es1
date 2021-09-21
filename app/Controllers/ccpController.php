<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;

class ccpController extends Controller{

    public function __construct() {}

    private static function checkSession(){
        if($_SESSION['userType'] == "CCP"){ return;}
        else header('Location: '.getenv('URL') .'erro404');
    }

    public static function index($params)
    {
        session_start();

        self::checkSession();

        $page = Views::render("template_administrativo","", [
            'URL' => '<base href="'.getenv('URL').'">',
            'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI - CCP',
            'userType' => 'CCP',
            'userName' => $_SESSION['userName'],
            'menu' => Views::getContentView('menus/menu_ccp')
          ]);

        echo $page;
    }

    public static function getMethods()
    {
        return ["index"];
    }

}
