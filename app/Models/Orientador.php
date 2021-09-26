<?php

namespace App\Models;

use PDO;
use PDOException;
use App\Utils\Errors\ConfirmPasswordException;
use App\Utils\Errors\CheckEmailException;
use App\Utils\Errors\PersonAlreadyUsedException;

class Orientador
{
    private $id;
    private $name;
    private $type;

    public function __construct($id, $name, $type){
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
    }

    public static function cadastro($name, $email, $password, $cpassword, $ccpConfirm)
    {
       
        try {

            if (!self::confirmPassword($password,$cpassword)) throw new ConfirmPasswordException();
            
    
            $conn = Connection::getConnection();
    
            if(!$id = self::checkEmail($conn, $email)) throw new CheckEmailException();
    
            if(!self::insertOrientador($conn, $name, $id, $password, $ccpConfirm)) throw new PersonAlreadyUsedException();

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

    private static function insertOrientador($conn, $name, $id_pessoa, $password, $CCPconfirm)
    {
        $query = "INSERT INTO orientador (_cpp, user, senha, id_pessoa) 
            VALUES ({$CCPconfirm},'{$name}', MD5('{$password}'), {$id_pessoa});";

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
