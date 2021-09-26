<?php

namespace App\Utils\Errors;

use Exception;

class PersonAlreadyUsedException extends Exception{

    public function errorMessage()
    {
    //error message
        $errorMsg = "O email já tem um usuário vinculado!!!";

        return $errorMsg;
    }

}