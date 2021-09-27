<?php

require __DIR__.'/vendor/autoload.php';

use \App\Core\Core;

$path = "http://localhost".$_SERVER['REQUEST_URI'];
putenv("URL=$path");

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();


require_once "_setEnvironment.php";


$c = new Core();

?>