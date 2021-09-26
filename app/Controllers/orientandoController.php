<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;
use App\Models\Reports;
use App\Utils\System;


class orientandoController extends Controller{

    public function __construct() {}

    //Checa Sessão
    private static function checkSession(){
        if($_SESSION['userType'] == "Orientando"){ return;}
        else header('Location: '.getenv('URL') .'erro404');
    }

    //carrega página Envia Relatório
    public static function index($params)
    {
        session_start();

        self::checkSession();

        $error = System::errorExists();
        $period = Reports::getPeriod();
        
        $page = Views::render("template_administrativo","enviar_relatorio", 
        [
            'URL' => '<base href="'.getenv('URL').'">',
            'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI - Orientando',
            'userType' => 'Orientando',
            'userName' => $_SESSION['userName'],
            'logout' => 'href="./logout/index/'.strval(md5(session_id())).'"',
            'menu' => Views::getContentView('menus/menu_orientando')
        ],
        [
            'error' => $error,
            'periodo' => $period
        ]);

        echo $page;
    }

    //Enviar Relatório
    public static function sendReport($params)
    {
        session_start();

        self::checkSession();

        if(isset($_POST['send_button'])){
            Reports::SendReportOrientando($_SESSION['userId'], $_SESSION['userName']);
            header('Location: '.getenv('URL') .'orientando');
        }
        else{
            header('Location: '.getenv('URL') .'orientando');
        }
    }


    //Histórico
    public static function history($params)
    {
        session_start();

        self::checkSession();
        
        $page = Views::render("template_administrativo","historico_relatorios", [
            'URL' => '<base href="'.getenv('URL').'">',
            'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI - Orientando',
            'userType' => 'Orientando',
            'userName' => $_SESSION['userName'],
            'logout' => 'href="./logout/index/'.strval(md5(session_id())).'"',
            'menu' => Views::getContentView('menus/menu_orientando')
          ]);

        echo $page;

    }



    public static function getMethods()
    {
        return ["index", "history", "sendReport"];
    }

}
