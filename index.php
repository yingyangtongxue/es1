<?php

require __DIR__.'/vendor/autoload.php';

use \App\Core\Core;


$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/es1/';
putenv("URL=$root");


$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();


require_once "_setEnvironment.php";


$c = new Core();

?>