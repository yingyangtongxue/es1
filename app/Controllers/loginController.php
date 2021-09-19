<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;
use App\Models\User;
use App\Utils\System;

class loginController extends Controller{

    public function __construct() {}

    public static function index($params)
    {
        session_start();
        User::isLoggedIn();

        $page = Views::render("template_usp","login", [
            'URL' => '<base href="'.getenv('URL').'">',
            'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI - Login'
          ]);

        
        $error = System::errorExists();
        
        echo str_replace('{{error}}', $error, $page);
    }

    public static function autentication(){
        if (isset($_POST['email']) && isset($_POST['password']))
        {
            User::login();
        }
        else{
            header('Location: '.getenv('URL') .'login');
        }
    }

    public static function getMethods(){
        return ["index","autentication"];
    }

}
