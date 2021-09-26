<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;
use App\Models\Reports;
use App\Utils\POSTData;


class ccpController extends Controller{

    public function __construct() {}

    //Checa Sessão
    private static function checkSession(){
        if($_SESSION['userType'] == "CCP"){ return;}
        else header('Location: '.getenv('URL') .'erro404');
    }

    //Listar Relatórios
    private static function listReports($id_ccp){
        $reports = Reports::getReportsCCP($id_ccp);
        return ($reports != "") ?  $reports : Views::getContentView("no_reports");
    }

    //Relatórios Pendentes
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

    //Salvar ou Enviar Parecer
    public static function updateReport(){
        session_start();

        self::checkSession();

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


    //Lista Histórico
    private static function listHistory(){
        $reports = Reports::getHistoryCCP();
        return ($reports != "") ?  $reports : Views::getContentView("no_reports");
    }

    
    //Histórico 
    public static function history($params)
    {
        session_start();

        self::checkSession();
        $reports = self::listHistory();

        echo Views::render("template_administrativo","historico_relatorios", 
        [
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

    }


    //Gerenciar Período 
    public static function period($params)
    {
        session_start();

        self::checkSession();

        $period = Reports::getPeriod();
        if($period == "FORA DO PERÍODO DE ENVIO") $period = 'abrir_periodo';
        else $period = 'fechar_periodo';
        
        $page = Views::render("template_administrativo",$period, [
            'URL' => '<base href="'.getenv('URL').'">',
            'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI - CCP',
            'userType' => 'CCP',
            'userName' => $_SESSION['userName'],
            'logout' => 'href="./logout/index/'.strval(md5(session_id())).'"',
            'menu' => Views::getContentView('menus/menu_ccp')
            ],
            [
            
            ]);

        echo $page;
    }

    private static function closePeriod(){
        
    }



    public static function getMethods()
    {
        return ["index", "updateReport","history","period"];
    }

}
