<?php

require __DIR__.'/vendor/autoload.php';

use \App\Core\Core;

$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . str_replace("index.php", "",getenv('SCRIPT_NAME'));
putenv("URL=$root");


$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();


require_once "_setEnvironment.php";


$c = new Core();

?>