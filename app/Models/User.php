<?php

namespace App\Models;

use App\Utils\POSTData;
use Exception;

class User
{

    public function __construct(){}

    public static function login()
    {
        $data = POSTData::postLoginInfo();
        $auth = Autentication::login($data["email"], $data["password"]);


        if($auth instanceof Orientador || $auth instanceof Orientando)
        {
            print_r("<pre>");
            print_r("LOGADO: \n");
            print_r($auth->getId()."\n");
            print_r($auth->getType()."\n");
            print_r($auth->getName());
            print_r("</pre>");
            session_start();
            //$_SESSION['userId'] = $auth['userId'];
            //$_SESSION['userType'] = $auth['userType'];
            //$_SESSION['nome'] = $auth['nome'];
        }
        else{
            session_start();
            $_SESSION["error"] = $auth->errorMessage();
            header('Location: '.getenv('URL') .'login');
        }
    }

    public static function cadastro($person)
    {
        if($person == 'orientador') 
        {
            $data = POSTData::postCadastroOrientador();
            $status = Orientador::cadastro($data["name"], $data["email"], $data["password"], $data["cpassword"], $data["CCPconfirm"]);

            if($status === true){
                header('Location: '.getenv('URL') .'home');
            }
            else
            {
                session_start();
                $_SESSION["error"] = $status->errorMessage();
                header('Location: '.getenv('URL') .'cadastro');
            }
        }
        else{

        }    
    }
 
}
