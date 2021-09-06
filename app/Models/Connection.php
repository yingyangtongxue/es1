<?php

namespace App\Models;

use Exception;
use PDO;

class Connection
{

    private static $con;

    public function __construct(){}

    public static function getConnection()
    {
        $dbname = getenv('DBNAME');
        $host = getenv('HOST');
        $user = getenv('USER');
        $password = getenv('PASSWORD');

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
