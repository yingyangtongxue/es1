<?php

namespace App\Utils;


class POSTData{

    public function __construct(){}

    public static function postLoginInfo(){
        $email = $_POST['email'];
        $password = $_POST['password'];
        unset($_POST['email'], $_POST['password']);

        return array("email" => $email, "password" => $password);
    }

    public static function postCadastroOrientador()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        isset($_POST['CCPconfirm']) ? $CCPconfirm = 1 : $CCPconfirm = 0;

        unset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['cpassword'], $_POST['CCPconfirm']);

        return array("name" => $name, "email" => $email, "password" => $password, "cpassword" => $cpassword, "CCPconfirm" => $CCPconfirm);
    }

}