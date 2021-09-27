<?php

require __DIR__.'/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'/../../');
$dotenv->load();

use App\Models\Connection;

if (isset($_POST['id_rel'])){

    $id_rel = $_POST['id_rel'];

    $conn = Connection::getConnection();

            $query = "SELECT cpp.id_aval, r.caminho, avop.descricao as 'nota_prof', e.descricao as 'comment_aluno', 
            p.nome as 'nome_prof', av.descricao as 'comment_prof', avopcpp.descricao as 'nota_cpp', cpp.descricao as 'comment_cpp'
        FROM avaliacao as av
            inner join avalOpcao as avop
            on av.id_avalOpcao = avop.id_avalOpcao
            inner join orientador as pr
            on av.id_orientador = pr.id_orientador
                    inner join pessoa as p
                    on pr.id_pessoa = p.id_pessoa
            inner join relatorio as r
            on av.id_relatorio = r.id_relatorio
                inner join periodo as pe
                on r.id_periodo = pe.id_periodo
                inner join elaboracao as e
                on r.id_relatorio = e.id_relatorio
            inner join avaliacao as cpp
            on av.id_aval = cpp.id_aval_pai
                inner join avalOpcao as avopcpp
                on cpp.id_avalOpcao = avopcpp.id_avalOpcao
        WHERE r.id_relatorio = {$id_rel} AND pe._aberto = 1;";

    $result = $conn->query($query);

    if($result)
    {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            echo json_encode(array("id_aval"=> $row['id_aval'] ,"caminho"=> $row['caminho'],"comment_aluno" => $row['comment_aluno'],"nome_prof" => $row['nome_prof'] ,"nota_prof" => $row['nota_prof'], "comment_prof" => $row['comment_prof'], "nota_cpp" => $row['nota_cpp'], "comment_cpp" => $row['comment_cpp'] ));
    }       

    
    exit;
}     

?>

