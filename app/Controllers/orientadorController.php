<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;
use App\Models\Reports;

class orientadorController extends Controller{

    public function __construct() {}

    private static function listReports($id_orientador){
        $reports = Reports::getReportsOrientador($id_orientador);
        return ($reports != "") ?  $reports : Views::getContentView("no_reports");
    }

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
        $reports = self::listReports($_SESSION['userId']);
       

        echo Views::render("template_administrativo","relatorios_pendentes", 
        [
            'URL' => '<base href="'.getenv('URL').'">',
            'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI - Orientador',
            'userType' => 'Orientador',
            'userName' => $_SESSION['userName'],
            'logout' => 'href="./logout/index/'.strval(md5(session_id())).'"',
            'menu' => Views::getContentView($menu)
        ],
        [
            'reports' => $reports
        ]);

    }

    public static function updateReport(){
        if ($_POST['action'] == 'Salvar') {
            //action for update here
        } else if ($_POST['action'] == 'Enviar') {
            //action for delete
        } else {
            //invalid action!
        }
    }

    public static function getMethods()
    {
        return ["index", "updateReport"];
    }

}
