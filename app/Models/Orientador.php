<?php

namespace App\Models;

use PDO;

class Orientador
{

    public function __construct(){}

    public static function cadastro()
    {
       
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        isset($_POST['CCPconfirm']) ? $CCPconfirm = 1 : $CCPconfirm = 0;
        if (!self::confirmPassword($password, $cpassword)){
            header('Location: '.getenv('URL') .'cadastro');
        }
        $conn = Connection::getConnection();
        if(!$id = self::checkEmail($conn, $email)){
            header('Location: '.getenv('URL').'cadastro');
        }
        self::insertPerson($conn, $name, $id, $password, $CCPconfirm);
        header('Location: '.getenv('URL'));
        
    }
    
    private static function confirmPassword($pass, $cpass)
    {
        return ($pass == $cpass) ? true : false;
    }

    private static function checkEmail($conn, $email)
    {
        $query = "SELECT id_pessoa from pessoa where email = '{$email}'";
        $id_pessoa= 0;
        $result = $conn->query($query);

        if($result)
                while($row = $result->fetch(PDO::FETCH_ASSOC))
                    $id_pessoa = $row['id_pessoa'];

        return $id_pessoa;
    }

    private static function insertPerson($conn, $name, $id, $password, $CCPconfirm)
    {
        $query = "INSERT INTO orientador (_cpp, user, senha, id_pessoa) 
            VALUES ({$CCPconfirm},'{$name}', MD5('{$password}'), {$id});";
        $conn->query($query);

        return true;
    }
       
}
