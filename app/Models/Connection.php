<?php

namespace App\Models;

use Exception;
use PDO;

class Connection
{

    private static $con;

    private static function __construct(){}

    private static function getConnection()
    {
        $dbname = '';
        $host = 'localhost';
        $user = 'root';
        $password = '';

        if (!isset(self::$con)) {
            try {
                self::$con = new PDO('mysql:dbname=' . $dbname . ';host=' . $host, $user, $password);
            } catch (Exception $e) 
            {
                echo 'Erro: ' . $e;
            }
        }

        return self::$con;
    }
}
