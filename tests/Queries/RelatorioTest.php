<?php
use \PHPUnit\Framework\TestCase;
use App\Models\Connection;


class RelatorioTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();

        (new TestRegisters())->insertTests();
    }

    public function __destruct()
    {
        $conn = Connection::getConnection();

        $stmt = $conn->query("SELECT id_aval FROM avaliacao");
        $ids = $stmt->fetchAll();
        $conn->query("DELETE FROM avaliacao WHERE id_aval = ". (isset($ids[0]) ? $ids[0]['id_aval'] : 0));
        $conn->query("DELETE FROM avaliacao WHERE id_aval = ". (isset($ids[1]) ? $ids[1]['id_aval'] : 0));

        $stmt = $conn->query("SELECT id_elaboracao FROM elaboracao");
        $ids = $stmt->fetchAll();
        $conn->query("DELETE FROM elaboracao WHERE id_elaboracao = ". (isset($ids[0]) ? $ids[0]['id_elaboracao'] : 0));
        $conn->query("DELETE FROM elaboracao WHERE id_elaboracao = ". (isset($ids[1]) ? $ids[1]['id_elaboracao'] : 0));

        $stmt = $conn->query("SELECT id_relatorio FROM relatorio");
        $ids = $stmt->fetchAll();
        $conn->query("DELETE FROM relatorio WHERE id_relatorio = ". (isset($ids[0]) ? $ids[0]['id_relatorio'] : 0));
        $conn->query("DELETE FROM relatorio WHERE id_relatorio = ". (isset($ids[1]) ? $ids[1]['id_relatorio'] : 0));

        $conn->query("DELETE FROM periodo WHERE id_orientador = {$this->getIdOrientador('Usuário 1')}");
        $conn->query("DELETE FROM periodo WHERE id_orientador = {$this->getIdOrientador('Usuário 5')}");


        (new TestRegisters())->deleteTests();
    }

    private function getIdOrientador(string $user)
    {
        $conn = Connection::getConnection();
        $stmt = $conn->query("SELECT id_orientador FROM orientador WHERE user = '{$user}'");
        $stmt->execute();
        $fetch = $stmt->fetch();
        return !!$fetch ? $fetch["id_orientador"] : 0;
    }

    public function testInsertPeriodo()
    {
        $conn = Connection::getConnection();
        $id_orientador = $this->getIdOrientador("Usuário 1");
        $conn->query(
            "INSERT INTO periodo (dataInicio, dataTermino, _aberto, id_orientador)
                VALUES ('2021-09-01 23:59:59', '2021-10-31 23:59:59', 1, {$id_orientador})"
        );
        $this->assertTrue(!!$conn->lastInsertId());

        $id_orientador = $this->getIdOrientador("Usuário 5");
        $conn->query(
            "INSERT INTO periodo (dataInicio, dataTermino, _aberto, id_orientador) 
                VALUES ('2020-09-01 23:59:59', '2020-10-31 23:59:59', 0, {$id_orientador})"
        );
        $this->assertTrue(!!$conn->lastInsertId());
    }

    public function testInsertRelatorio()
    {
        $conn = Connection::getConnection();
        $stmt = $conn->query("SELECT id_periodo FROM periodo");
        $ids = $stmt->fetchAll();

        $conn->query("INSERT INTO relatorio (id_periodo) VALUES ({$ids[0]['id_periodo']})");
        $this->assertTrue(!!$conn->lastInsertId());

        $conn->query("INSERT INTO relatorio (id_periodo) VALUES ({$ids[1]['id_periodo']})");
        $this->assertTrue(!!$conn->lastInsertId());
    }

    public function testInsertElaboracao()
    {
        $conn = Connection::getConnection();
        $stmt = $conn->query("SELECT id_orientando FROM orientando");
        $ids_orientandos = $stmt->fetchAll();
        $stmt = $conn->query("SELECT id_relatorio FROM relatorio");
        $ids_relatorios = $stmt->fetchAll();

        $conn->query(
            "INSERT INTO elaboracao (dataEnvio, descricao, dataInicio, id_orientando, id_relatorio)
                VALUES (
                    '2021-09-25',
                    'Esse relatório me deu trabalho.', 
                    '2021-09-24', 
                    {$ids_orientandos[0]['id_orientando']},
                    {$ids_relatorios[0]['id_relatorio']}
                )"
        );
        $this->assertTrue(!!$conn->lastInsertId());

        $conn->query(
            "INSERT INTO elaboracao (dataEnvio, descricao, dataInicio, id_orientando, id_relatorio)
                VALUES (
                    '2021-09-25',
                    'Esse relatório me deu trabalho.', 
                    '2021-09-24', 
                    {$ids_orientandos[1]['id_orientando']},
                    {$ids_relatorios[1]['id_relatorio']}
                )"
        );
        $this->assertTrue(!!$conn->lastInsertId());
    }

    public function testInsertAvaliacao()
    {
        $conn = Connection::getConnection();
        $stmt = $conn->query("SELECT id_orientador FROM orientador");
        $ids_orientadores = $stmt->fetchAll();
        $stmt = $conn->query("SELECT id_relatorio FROM relatorio");
        $ids_relatorios = $stmt->fetchAll();

        $conn->query(
            "INSERT INTO avaliacao (dataInicio, id_avalOpcao, id_relatorio, id_orientador)
                VALUES (
                    '2021-09-16', 
                    4, 
                    {$ids_relatorios[0]['id_relatorio']}, 
                    {$ids_orientadores[0]['id_orientador']}
                )"
        );
        $this->assertTrue(!!$conn->lastInsertId());

        $conn->query(
            "INSERT INTO avaliacao (dataInicio, id_avalOpcao, id_relatorio, id_orientador)
                VALUES (
                    '2021-09-16', 
                    2, 
                    {$ids_relatorios[1]['id_relatorio']}, 
                    {$ids_orientadores[1]['id_orientador']}
                )"
        );
        $this->assertTrue(!!$conn->lastInsertId());
    }

    public function testListagemRelatoriosPendentesCCP()
    {
        $conn = Connection::getConnection();
        $stmt = $conn->query("SELECT pe._aberto, pr.id_orientador FROM avaliacao as av inner join relatorio as r on av.id_relatorio = r.id_relatorio inner join periodo as pe on r.id_periodo = pe.id_periodo inner join elaboracao as e on r.id_relatorio = e.id_relatorio inner join orientando as a on e.id_orientando = a.id_orientando inner join pessoa as p on a.id_pessoa = p.id_pessoa inner join orientador as pr on a.id_orientador = pr.id_orientador");
        $ids = $stmt->fetchAll();

        $stmt = $conn->query(
            "SELECT p.nome, e.dataEnvio, e.descricao, r.caminho, av.dataInicio
            FROM avaliacao as av
                inner join relatorio as r
                on av.id_relatorio = r.id_relatorio
                    inner join periodo as pe
                    on r.id_periodo = pe.id_periodo
                    inner join elaboracao as e
                    on r.id_relatorio = e.id_relatorio
                        inner join orientando as a
                        on e.id_orientando = a.id_orientando
                            inner join pessoa as p
                            on a.id_pessoa = p.id_pessoa
                            inner join orientador as pr
                            on a.id_orientador = pr.id_orientador
            WHERE pr.id_orientador = {$ids[0]['id_orientador']} AND av.dataAval IS NULL
            AND av.id_aval_pai IS NULL AND pe._aberto = 1
            ORDER BY av.dataInicio"
        );
        $result = $stmt->fetchAll();
        if($ids[0]['_aberto'] == 1) {
            $this->assertEquals($result[0]['dataEnvio'], '2021-09-25');
            $this->assertEquals($result[0]['dataInicio'], '2021-09-16');
            $this->assertEquals($result[0]['descricao'], 'Esse relatório me deu trabalho.');
        }
        else $this->assertTrue(!$result);

        $stmt = $conn->query(
            "SELECT p.nome, e.dataEnvio, e.descricao, r.caminho, av.dataInicio
            FROM avaliacao as av
                inner join relatorio as r
                on av.id_relatorio = r.id_relatorio
                    inner join periodo as pe
                    on r.id_periodo = pe.id_periodo
                    inner join elaboracao as e
                    on r.id_relatorio = e.id_relatorio
                        inner join orientando as a
                        on e.id_orientando = a.id_orientando
                            inner join pessoa as p
                            on a.id_pessoa = p.id_pessoa
                            inner join orientador as pr
                            on a.id_orientador = pr.id_orientador
            WHERE pr.id_orientador = {$ids[1]['id_orientador']} AND av.dataAval IS NULL
            AND av.id_aval_pai IS NULL AND pe._aberto = 1
            ORDER BY av.dataInicio"
        );
        $stmt->execute();
        $result = $stmt->fetchAll();
        if($ids[1]['_aberto'] == 1) {
            $this->assertEquals($result[0]['dataEnvio'], '2021-09-25');
            $this->assertEquals($result[0]['dataInicio'], '2021-09-16');
            $this->assertEquals($result[0]['descricao'], 'Esse relatório me deu trabalho.');
        }
        else $this->assertTrue(!$result);

        $this->assertTrue(true);
    }
}