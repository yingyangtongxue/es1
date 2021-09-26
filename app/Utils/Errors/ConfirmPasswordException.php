<?php

namespace App\Utils\Errors;

use Exception;

class ConfirmPasswordException extends Exception{

    public function errorMessage()
    {
    //error message
        $errorMsg = "O campo senha e confirmar senha não batem!!!";

        return $errorMsg;
    }

}