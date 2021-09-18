<?php

namespace App\Utils\Errors;

class System{

    public function __construct() {  }

    public static function errorExists()
    {
      session_start();
      $error = "";

      if(isset($_SESSION["error"]) && !empty($_SESSION["error"])) 
      {
        $error = '<div class="error">'.$_SESSION["error"].'</div>';
        unset($_SESSION["error"]);
      } 

      return $error;
    }

    public static function success(){

    }

}