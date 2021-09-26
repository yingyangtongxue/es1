<?php

namespace App\Models;

use App\Utils\POSTData;
use Exception;

class User
{

    public function __construct(){}

    public static function isLoggedIn(){
        if( isset($_SESSION['userId']) && isset($_SESSION['userType']))
        {
            if($_SESSION['userType'] == "Orientando") header('Location: '.getenv('URL') .'orientando');
            elseif($_SESSION['userType'] == "Orientador") header('Location: '.getenv('URL') .'orientador');
            elseif($_SESSION['userType'] == "CCP") header('Location: '.getenv('URL') .'ccp');
        }
    }

    public static function login()
    {
        $data = POSTData::postLoginInfo();
        $auth = Autentication::login($data["email"], $data["password"]);

        session_start();
        if($auth instanceof Orientador || $auth instanceof Orientando)
        {
            $_SESSION['userId'] = $auth->getId();
            $_SESSION['userType'] = $auth->getType();
            $_SESSION['userName'] = $auth->getName();
            

            self::isLoggedIn();
        }
        else{
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
                header('Location: '.getenv('URL') .'');
            }
            else
            {
                session_start();
                $_SESSION["error"] = $status->errorMessage();
                header('Location: '.getenv('URL') .'cadOrientador');
            }
        }
        else{

            $data = POSTData::postCadastroOrientando();
        
            $status = Orientando::cadastro($data["name"], $data["email"], $data["password"], $data["cpassword"], $data["id_orientador"]);
    
            if($status === true){
                header('Location: '.getenv('URL') .'');
            }
            else
            {
                session_start();
                $_SESSION["error"] = $status->errorMessage();
                header('Location: '.getenv('URL') .'cadOrientando');
            }
        }    
    }
 
}
