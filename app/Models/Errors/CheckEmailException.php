<?php

namespace App\Models\Errors;

use Exception;

class CheckEmailException extends Exception{

    public function errorMessage()
    {
    //error message
        $errorMsg = "Este email não está associado a nenhuma pessoa!!!";

        return $errorMsg;
    }

}