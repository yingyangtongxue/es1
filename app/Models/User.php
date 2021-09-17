<?php

namespace App\Models;

use App\Utils\POSTData;

class User
{

    public function __construct(){}

    public static function login()
    {
        $auth = Autentication::login();

        if($auth)
        {
            print_r("<pre>");
            print_r("LOGADO: \n");
            print_r( $auth['userId']."\n");
            print_r($auth['userType']);
            print_r("</pre>");
            session_start();
            $_SESSION['userId'] = $auth['userId'];
            $_SESSION['userType'] = $auth['userType'];
        }
        else{
            print_r("<pre> NÃO LOGADO!");
            print_r("</pre>");
        }
    }

    public static function cadastro($person)
    {
        if($person == 'orientador') 
        {
            $data = POSTData::postCadastroOrientador();
            $status = Orientador::cadastro($data);

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
