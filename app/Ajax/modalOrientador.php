<?php

require __DIR__.'/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'/../../');
$dotenv->load();

use App\Models\Connection;

if (isset($_POST['id_rel'])){

    $id_rel = $_POST['id_rel'];


    $conn = Connection::getConnection();

    $query = "SELECT r.caminho, avop.descricao as 'nota', e.descricao as 'comment_aluno', av.descricao as 'comment_prof'
    FROM avaliacao as av
        inner join avalOpcao as avop
        on av.id_avalopcao = avop.id_avalopcao
        inner join relatorio as r
        on av.id_relatorio = r.id_relatorio
            inner join periodo as pe
            on r.id_periodo = pe.id_periodo
            inner join elaboracao as e
            on r.id_relatorio = e.id_relatorio
    WHERE r.id_relatorio = {$id_rel} AND pe._aberto = 1;";

    $result = $conn->query($query);

   

    if($result)
    {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            echo json_encode(array("caminho"=> $row['caminho'], "nota" => $row['nota'], "comment_aluno" => $row['comment_aluno'], "comment_prof" => $row['comment_prof']));
    }       
    
    exit;
}     

?>