<?php

namespace App\Models;

use App\Models\Connection;
use PDO;


class Autentication
{

    public function __construct(){}

    public static function login()
    {
        if (isset($_POST['email']) && isset($_POST['password'])){
        
            $email = $_POST['email'];
            $senha = $_POST['password'];
            $conn = Connection::getConnection();
            
            if(!$id = self::searchID($conn, $email)) return null;

            return self::validatePerson($conn, $id, $senha);
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
        $query = "SELECT pr.id_orientador
            FROM pessoa as p 
                inner join orientador as pr
                on p.id_pessoa = pr.id_pessoa
            WHERE p.id_pessoa = '{$id}' AND pr.senha = MD5('{$senha}');";
        $id_orientador = 0;
        $result = $conn->query($query);

        if($result)
                while($row = $result->fetch(PDO::FETCH_ASSOC))
                    $id_orientador = $row['id_orientador'];

        return $id_orientador;
    }

    private static function validateOrientando($conn, $id, $senha){
        $query = "SELECT a.id_orientando
            FROM pessoa as p 
                inner join orientando as a
                on p.id_pessoa = a.id_pessoa
            WHERE p.id_pessoa = '{$id}' AND a.senha = MD5('{$senha}');";
        $id_orientando= 0;
        $result = $conn->query($query);

        if($result)
                while($row = $result->fetch(PDO::FETCH_ASSOC))
                    $id_orientando = $row['id_orientando'];

        return $id_orientando;
    }

    private static function validatePerson($conn, $id_pessoa, $senha){
        $id = self::validateOrientador($conn, $id_pessoa, $senha);
        if($id) return array("userId"=>$id, "userType"=>"Orientador");

        $id = self::validateOrientando($conn, $id_pessoa, $senha);
        return ($id) ? array("userId"=>$id, "userType"=>"Orientando") :  null;
    }
    
       
}

?>
