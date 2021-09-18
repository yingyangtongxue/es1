<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Utils\Errors\ConfirmPasswordException;
use App\Utils\Errors\CheckEmailException;
use App\Utils\Errors\PersonAlreadyUsedException;


class Orientando
{
    private $id;
    private $name;
    private $type;

    public function __construct($id, $name, $type){
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
    }


    public static function cadastro($data)
    {
       
        try {

            if (!self::confirmPassword($data["password"], $data["cpassword"])) throw new ConfirmPasswordException();
            
    
            $conn = Connection::getConnection();
    
            if(!$id = self::checkEmail($conn, $data["email"])) throw new CheckEmailException();

            //To-Do: Verificar se Orientador Associado Existe
    
            if(!self::insertOrientando($conn, $data["ra"], $data["name"], $data["password"],  $id, $data["id_orientador"])) throw new PersonAlreadyUsedException();

            return true;

        } catch (ConfirmPasswordException $e) {
            return $e;
        } catch (CheckEmailException $e) {
            return $e;
        } catch (PersonAlreadyUsedException $e) {
            return $e;
        }
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

    private static function insertOrientando($conn, $ra, $name, $password, $id_pessoa, $id_orientador)
    {
        $query = "INSERT INTO orientando (ra, user, senha, id_pessoa, id_orientador) 
            VALUES ('{$ra}', '{$name}', MD5('{$password}'), {$id_pessoa}, {$id_orientador});";


        try{
            $conn->query($query);
        }
        catch(PDOException $e){
            if($e->getCode() == 23000){
                return false;
            }
        }
        
        return true;
    }

    //Getters
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getType(){
        return $this->type;
    }
       
}
