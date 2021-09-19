<?php

namespace App\Utils;

class System{

    public function __construct() {  }

    public static function errorExists()
    {
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