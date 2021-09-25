<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;
use App\Models\Reports;
use App\Utils\POSTData;

class orientadorController extends Controller{

    public function __construct() {}

    //Checa sessão
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

    //Lista Relatórios
    private static function listReports($id_orientador){
        $reports = Reports::getReportsOrientador($id_orientador);
        return ($reports != "") ?  $reports : Views::getContentView("no_reports");
    }

    //Relatórios Pendentes
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
        if (isset($_POST['save_button'])) {
            $data = POSTData::postSave();
            Reports::saveReport($data['id_aval'],$data['select'], $data['comentario'] );
            header('Location: '.getenv('URL') .'orientador');
        } else if (isset($_POST['send_button'])) {
            $data = POSTData::postSave();
            Reports::sendReport($data['id_aval'],$data['select'], $data['comentario'] );
            header('Location: '.getenv('URL') .'orientador');
        } else {
            header('Location: '.getenv('URL') .'');
        }
    }

    //Lista Histórico
    private static function listHistory($id_orientador){
        $reports = Reports::getHistoryOrientador($id_orientador);
        return ($reports != "") ?  $reports : Views::getContentView("no_reports");
    }

    
    //Histórico
    public static function history($params)
    {
        session_start();

        $menu = self::checkSession();
        $reports = self::listHistory($_SESSION['userId']);

        echo Views::render("template_administrativo","historico_relatorios", 
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

    public static function getMethods()
    {
        return ["index", "updateReport", "history"];
    }

}
