<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;

class orientadorController extends Controller{

    public function __construct() {}

    private static function checkSession(){
        if($_SESSION['userType'] == "Orientador")
        {
            return 'menus/menu_orientador';
        }
        elseif($_SESSION['userType'] == "CCP")
        {
            return 'menus/menu_ccp_orientador';
        }
        else header('Location: '.getenv('URL') .'erro404');
    }

    public static function index($params)
    {
        session_start();

        $menu = self::checkSession();

        $page = Views::render("template_administrativo","", [
            'URL' => '<base href="'.getenv('URL').'">',
            'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI - Orientador',
            'userType' => 'Orientador',
            'userName' => $_SESSION['userName'],
            'logout' => 'href="./logout/index/'.strval(md5(session_id())).'"',
            'menu' => Views::getContentView($menu)
          ]);

        echo $page;
    }

    public static function getMethods()
    {
        return ["index"];
    }

}
