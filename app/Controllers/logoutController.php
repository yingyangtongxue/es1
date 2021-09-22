<?php

namespace App\Controllers;

use App\Core\Controller;


class logoutController extends Controller{

    public function __construct() {}

    public static function index($params)
    {
        session_start();

        $params = $params[0];
        $token = md5(session_id());
       
        if(isset($params) && $params == $token) {
           unset(  $_SESSION['userId'], $_SESSION['userType'], $_SESSION['userName']);
           session_destroy();
           header('Location: '.getenv('URL') .'');
        } else {
           header('Location: '.getenv('URL') .'');
        }
    }
}
