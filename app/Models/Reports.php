<?php

namespace App\Models;

use mysqli;
use PDOStatement;
use PDO;

class Reports
{
    public function __construct()
    {
    }

    public static function getReportsOrientador($id_orientador)
    {
        $conn = Connection::getConnection();

        //get nos Relatórios Ainda Não Lidos
        $query = "SELECT p.nome, e.dataEnvio, e.descricao, r.caminho, av.dataInicio
        FROM avaliacao as av
            inner join relatorio as r
            on av.id_relatorio = r.id_relatorio
                inner join elaboracao as e
                on r.id_relatorio = e.id_relatorio
                    inner join orientando as a
                    on e.id_orientando = a.id_orientando
                        inner join pessoa as p
                        on a.id_pessoa = p.id_pessoa
                        inner join orientador as pr
                        on a.id_orientador = pr.id_orientador
        WHERE pr.id_orientador = {$id_orientador} AND av.dataAval IS NULL
        AND av.id_aval_pai IS NULL
        ORDER BY av.dataInicio;";

        $report = "";
        $result = $conn->query($query);

        if ($result->rowCount()) {
            $report =  "<div class='main-container'>
                            <h1>Relatórios Pendentes</h1> 
                            <div class='relatorios-pendentes'> 
                                <ul>";
            while ($row = $result->fetch(PDO::FETCH_ASSOC))
                if ($row['dataInicio'] == null)
                    $report = $report . "<li class='modalbutton unread'>
                                            <i class='fas fa-envelope'></i>
                                                <p>
                                                     Relatório PPgSI - " . $row['nome'] . "    
                                                </p>
                                                <p class='date'>
                                                        " . $row['dataEnvio'] . "
                                                </p>
                                        </li>" . "\n";
                else {
                    $report = $report . "<li class='modalbutton read'>
                                            <i class='fas fa-envelope'></i>
                                                <p>
                                                    Relatório PPgSI - " . $row['nome'] . "    
                                                </p>
                                                <p class='date'>
                                                     " . $row['dataEnvio'] . "
                                                </p>
                                         </li>" . "\n";
                }
                
            $report =  $report . "</ul> </div> </div>";
        }
        return $report;
    }
}
