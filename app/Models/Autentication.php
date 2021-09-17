<?php

namespace App\Models;

use App\Models\Connection;
use App\Utils\Errors\IncorrectLoginException;
use PDO;


class Autentication
{

    public function __construct(){}

    public static function login($data)
    {
        
        $conn = Connection::getConnection();

        try{
            if(!$id = self::searchID($conn, $data["email"])) throw new IncorrectLoginException();

            if(!$info = self::validatePerson($conn, $id, $data["password"])) throw new IncorrectLoginException();

            return $info;
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
        $query = "SELECT pr.id_orientador, pr._cpp, p.nome
            FROM pessoa as p 
                inner join orientador as pr
                on p.id_pessoa = pr.id_pessoa
            WHERE p.id_pessoa = {$id} AND pr.senha = MD5('{$senha}');";
        $id_orientador = 0;
        $ccp = 0;
        $name = "";
        $result = $conn->query($query);

        if($result)
                while($row = $result->fetch(PDO::FETCH_ASSOC))
                {
                    $id_orientador = $row['id_orientador'];
                    $ccp = $row['_cpp'];
                    $name = $row['nome'];
                }

        
        return array($id_orientador, $ccp, $name);
    }

    private static function validateOrientando($conn, $id, $senha){
        $query = "SELECT a.id_orientando, p.nome
            FROM pessoa as p 
                inner join orientando as a
                on p.id_pessoa = a.id_pessoa
            WHERE p.id_pessoa = {$id} AND a.senha = MD5('{$senha}');";
        $id_orientando= 0;
        $name = "";
        $result = $conn->query($query);

        if($result)
                while($row = $result->fetch(PDO::FETCH_ASSOC))
                {
                    $id_orientando = $row['id_orientando'];
                    $name = $row['nome'];
                }

        return array($id_orientando, $name);
    }

    private static function validatePerson($conn, $id_person, $senha){
        $person = self::validateOrientador($conn, $id_person, $senha);
        if($person[0]) 
        {
            if($person[1]) return array("userId"=>$person[0], "userType"=>"CCP", "nome" => $person[2]);
            else return array("userId"=>$person[0], "userType"=>"Orientador", "nome" => $person[2]);
        }

        $person = self::validateOrientando($conn, $id_person, $senha);
        return ($person[0]) ? array("userId"=>$person[0], "userType"=>"Orientando", "nome" => $person[1]) :  null;
    }
    
       
}
