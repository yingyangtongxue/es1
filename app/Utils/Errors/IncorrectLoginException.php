<?php

namespace App\Utils\Errors;

use Exception;

class IncorrectLoginException extends Exception{

    public function errorMessage()
    {
    //error message
        $errorMsg = "O email ou senha estão incorretos !!!";

        return $errorMsg;
    }

}