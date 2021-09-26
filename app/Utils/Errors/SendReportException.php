<?php

namespace App\Utils\Errors;

use Exception;

class SendReportException extends Exception{

    private string $msg;

    public function __construct($msg)
    {
        $this->msg = $msg;
    }

    public function errorMessage()
    {
    //error message
        return $this->msg;
    }

}