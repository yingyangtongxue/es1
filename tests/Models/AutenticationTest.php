<?php
use \PHPUnit\Framework\TestCase;
use App\Models\Autentication;
use App\Models\Orientador;
use App\Models\Orientando;
use App\Models\Connection;
use App\Utils\Errors\IncorrectLoginException;

class AutenticationTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();

        $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . "\..\..");
        $dotenv->load();

        try {
            $conn = Connection::getConnection();

            $conn->query("INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) VALUES ('123456789','12345678901', '1999-12-12', 'Usuario 1', 'email_valido@orientador.com')");
            $id_pessoa = $conn->lastInsertId();
            $conn->query("INSERT INTO orientador (_cpp, user, senha, id_pessoa) VALUES (1,'Usuario 1', MD5('senha_valida'), {$id_pessoa})");
            $id_orientador = $conn->lastInsertId();

            $conn->query("INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) VALUES ('234567890','23456789012', '1999-12-12', 'Usuario 2', 'email_valido@orientando.com')");
            $id_pessoa = $conn->lastInsertId();
            $conn->query("INSERT INTO orientando (user, senha, id_pessoa, id_orientador) VALUES ('Usuario 2', MD5('senha_valida'), {$id_pessoa}, {$id_orientador})");
        }
        catch(PDOException $e) {}
    }

    private function deletePersonWhereRg(string $rg)
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->query("SELECT id_pessoa FROM pessoa WHERE rg = {$rg}");
            $stmt->execute();
            $fetch = $stmt->fetch();
            if(isset($fetch["id_pessoa"])) {
                $id_pessoa = $fetch["id_pessoa"];
                $conn->query("DELETE FROM orientador WHERE id_pessoa = '{$id_pessoa}'");
                $conn->query("DELETE FROM orientando WHERE id_pessoa = '{$id_pessoa}'");
                $conn->query("DELETE FROM pessoa WHERE id_pessoa = {$id_pessoa}");
            }
        }
        catch(PDOException $e) {}
    }

    public function __destruct()
    {
        $this->deletePersonWhereRg("123456789");
        $this->deletePersonWhereRg("234567890");
    }

    public function testLoginEmailInvalido()
    {
        $result = (new Autentication())->login("email_invalido@example.com", "senha_qualquer");

        $this->assertEquals(IncorrectLoginException::class, $result::class);
    }
    
    public function testLoginSenhaInvalida()
    {
        $result = (new Autentication())->login("email_valido@example.com", "senha_invalida");

        $this->assertEquals(IncorrectLoginException::class, $result::class);
    }

    public function testLoginParametrosValidosParaOrientador()
    {
        $result = (new Autentication())->login("email_valido@orientador.com", "senha_valida");

        $this->assertEquals(Orientador::class, $result::class);
    }

    public function testLoginParametrosValidosParaOrientando()
    {
        $result = (new Autentication())->login("email_valido@orientando.com", "senha_valida");

        $this->assertEquals(Orientando::class, $result::class);
    }
}