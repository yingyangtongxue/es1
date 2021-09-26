<?php

require __DIR__.'/vendor/autoload.php';

use \App\Core\Core;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$c = new Core();

?>