<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;
use App\Models\Reports;

class ccpController extends Controller{

    public function __construct() {}

    private static function listReports(){
        $reports = Reports::getReportsCCP();
        return ($reports != "") ?  $reports : Views::getContentView("no_reports");
    }

    private static function checkSession(){
        if($_SESSION['userType'] == "CCP"){ return;}
        else header('Location: '.getenv('URL') .'erro404');
    }

    public static function index($params)
    {
        session_start();

        self::checkSession();
        $reports = self::listReports();

        $page = Views::render("template_administrativo","relatorios_pendentesCCP", [
            'URL' => '<base href="'.getenv('URL').'">',
            'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI - CCP',
            'userType' => 'CCP',
            'userName' => $_SESSION['userName'],
            'logout' => 'href="./logout/index/'.strval(md5(session_id())).'"',
            'menu' => Views::getContentView('menus/menu_ccp')
          ],
         [
            'reports' => $reports
         ]);

        echo $page;
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
