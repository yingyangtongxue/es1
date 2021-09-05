<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;


class loginController extends Controller{

    public function __construct() {}

    public static function index()
    {
        echo Views::render("template_usp","login", [
            'URL' => '<base href="'.getenv('URL').'">',
            'title' => 'Login'
          ]);
    }

}

