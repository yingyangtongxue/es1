<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;
use App\Models\User;

class loginController extends Controller{

    public function __construct() {}

    public static function index($params)
    {
        echo Views::render("template_usp","login", [
            'URL' => '<base href="'.getenv('URL').'">',
            'title' => 'Login'
          ]);
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
        return get_class_methods(get_class());
    }

}
