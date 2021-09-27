<?php

    $dbname = getenv('DBNAME');
    $host = getenv('HOST');
    $user = getenv('USER');
    $password = getenv('PASSWORD');

    try {
        $con = new PDO('mysql:dbname=' . $dbname . ';host=' . $host, $user, $password);
    } catch (Exception $e) 
    {
        if($e->getCode() == 1049){

            //Criando Conexão
            $db = new PDO("mysql:host=". $host,  $user, $password);

            //Criando Banco
            $db->query(file_get_contents(__DIR__."/app/database/structure.sql"));

            //Adicionando Alimentação Inicial
            $db->query(file_get_contents(__DIR__."/app/database/data.sql"));

            //Adicionando Procedures
            $db->query(file_get_contents(__DIR__."/app/database/routines.sql"));

            //Mandando o user para a Tela de Configuração
            header('Location: '.getenv('URL') .'config');
        }
    }
    
?>