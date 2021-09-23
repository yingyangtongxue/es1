<?php

namespace App\Models;

use App\Models\Connection;
use App\Utils\Errors\CheckEmailException;
use App\Utils\Errors\IncorrectLoginException;
use PDO;


class Autentication
{

    public function __construct(){}

    public static function login($email, $password)
    {
        
        $conn = Connection::getConnection();

        try{
            if(!$id = self::searchID($conn, $email)) throw new IncorrectLoginException();

            if(!$person = self::validatePerson($conn, $id, $password)) throw new IncorrectLoginException();

            return $person;
        }
        catch(IncorrectLoginException $e){
            return $e;
        }   
        
    }

    private static function searchID($conn, $email){

        $query = "SELECT id_pessoa FROM pessoa WHERE email = '{$email}';";
        $result = $conn->query($query);
        $id = 0;
        if($result)
                while($row = $result->fetch(PDO::FETCH_ASSOC))
                    $id = $row['id_pessoa'];

        return $id;
    }

    private static function validateOrientador($conn, $id, $senha){
        $query = "SELECT pr.id_orientador, pr._cpp, pr.user
            FROM pessoa as p 
                inner join orientador as pr
                on p.id_pessoa = pr.id_pessoa
            WHERE p.id_pessoa = {$id} AND pr.senha = MD5('{$senha}');";

        $result = $conn->query($query);
        $orientador = null;

        if($result)
                while($row = $result->fetch(PDO::FETCH_ASSOC))
                {
                    if($row['_cpp'] == 1) $orientador = new Orientador($row['id_orientador'], $row['user'], "CCP");
                    else $orientador = new Orientador($row['id_orientador'], $row['user'], "Orientador");
                }

        return $orientador;
    }

    private static function validateOrientando($conn, $id, $senha){
        $query = "SELECT a.id_orientando, a.user
            FROM pessoa as p 
                inner join orientando as a
                on p.id_pessoa = a.id_pessoa
            WHERE p.id_pessoa = {$id} AND a.senha = MD5('{$senha}');";
        
        $result = $conn->query($query);
        $orientando = null;

        if($result)
                while($row = $result->fetch(PDO::FETCH_ASSOC))
                {
                    $orientando = new Orientando($row['id_orientando'], $row['user'], "Orientando");
                    
                }

        return $orientando;
    }

    private static function validatePerson($conn, $id_person, $senha){
        $person = self::validateOrientador($conn, $id_person, $senha);
        if($person != null) {return $person;}

        $person = self::validateOrientando($conn, $id_person, $senha);
        return ($person != null) ? $person :  null;
    }
    
       
}
