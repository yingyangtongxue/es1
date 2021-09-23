<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Views;
use App\Models\User;
use App\Utils\System;
use App\Models\Connection;
use PDO;

class cadOrientandoController extends Controller{

    public function __construct() {}

    public static function index($params)
    {
        session_start();

        $error = System::errorExists();

        $select = self::fillSelect();

        echo Views::render("template_usp","cadOrientando", 
        [
          'URL' => '<base href="'.getenv('URL').'">',
          'title' => 'Sistema de Avaliação de Desempenho dos alunos do PPgSI - Cadastro Orientando'
        ], 
        [
            'error' => $error,
            'options' =>$select
        ]);
     
    }

    public static function cadastrar()
    {
        if (isset($_POST['email']) && isset($_POST['password']))
        {
            User::cadastro('orientando');
        }
        else{
            header('Location: '.getenv('URL') .'cadOrientando');
        }
    }

    private static function fillSelect(){

        $conn = Connection::getConnection();

        $query = "SELECT pr.id_orientador, p.nome 
                     FROM orientador as pr 
                     INNER JOIN pessoa as p 
                     ON pr.id_pessoa = p.id_pessoa;";

        $result = $conn->query($query);
        
        $select = "<option value='0' selected disabled>Selecione um Orientador</option>";
        if($result)
                while($row = $result->fetch(PDO::FETCH_ASSOC))
                    $select = $select . "<option value='".$row['id_orientador']."'>".$row['nome']."</option>"."\n";
                     
                   
        return $select;
    }

    public static function getMethods()
    {
        return ["index","cadastrar"];
    }

}
