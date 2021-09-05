<?php

namespace App\Controllers;

use App\Core\Controller;

class homeController extends Controller{

    public function __construct() {}

    public static function index()
    {
        echo 'home';
    }

}

