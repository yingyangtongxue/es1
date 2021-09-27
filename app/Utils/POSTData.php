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

    public static function postCadastroOrientando()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $id_orientador =  $_POST['select-orientador']; 

        unset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['cpassword'], $_POST['select-orientador']);

        return array("name" => $name, "email" => $email, "password" => $password, "cpassword" => $cpassword, "id_orientador" => $id_orientador);
    }


    public static function postSave()
    {
        $id_aval = $_POST['id_aval'];
        $select = $_POST['select'];
        $comentario = $_POST['comentario'];

        unset($_POST['id_aval'], $_POST['select'], $_POST['comentario']);

        return array("id_aval" => $id_aval, "select" => $select, "comentario" => $comentario);
    }

    public static function postOpenPeriod(){
        $data_atual = $_POST['data-atual'];
        $data_final = $_POST['data-final'];

        unset($_POST['data-atual'], $_POST['data-final']);

        return array("data_atual" => $data_atual,"data_final" => $data_final);
    }

    public static function postClosePeriod(){
        $close = $_POST['close_button'];

        unset($_POST['close_button']);

        return $close;
    }
}