<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;
use App\Models\Reports;
use App\Utils\POSTData;


class ccpController extends Controller{

    public function __construct() {}

    private static function listReports($id_ccp){
        $reports = Reports::getReportsCCP($id_ccp);
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
        $reports = self::listReports($_SESSION['userId']);

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

    public static function history($params)
    {
        session_start();

        $menu = self::checkSession();
       

        echo Views::render("template_administrativo","historico_relatoriosCCP", 
        [
            'URL' => '<base href="'.getenv('URL').'">',
            'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI - CCP',
            'userType' => 'CCP',
            'userName' => $_SESSION['userName'],
            'logout' => 'href="./logout/index/'.strval(md5(session_id())).'"',
            'menu' => Views::getContentView('menus/menu_ccp')
        ],
        [
            
        ]);

    }

    public static function updateReport(){
        session_start();
        if (isset($_POST['save_button'])) {
            $data = POSTData::postSave();
            Reports::saveReportCCP($data['id_aval'],$data['select'], $data['comentario'], $_SESSION['userId']);
            header('Location: '.getenv('URL') .'ccp');
        } else if (isset($_POST['send_button'])) {
            $data = POSTData::postSave();
            Reports::sendReportCCP($data['id_aval'],$data['select'], $data['comentario'], $_SESSION['userId']);
            header('Location: '.getenv('URL') .'ccp');
        } else {
            header('Location: '.getenv('URL') .'');
        }
    }

    public static function getMethods()
    {
        return ["index", "updateReport","history"];
    }

}
