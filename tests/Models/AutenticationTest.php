<?php
use \PHPUnit\Framework\TestCase;
use App\Models\Autentication;
use App\Models\Connection;
use App\Utils\Errors\IncorrectLoginException;

class AutenticationTest extends TestCase
{
    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . "\..\..");
        $dotenv->load();

        try {
            $conn = Connection::getConnection();
            $conn->query("INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) VALUES ('123456789','12345678901', '1999-12-12', 'Usuario 1', 'email_valido@example.com')");
            $id_pessoa = $conn->lastInsertId();
            $conn->query("INSERT INTO orientador (_cpp, user, senha, id_pessoa) VALUES (1,'Usuario 1', MD5('senha_valida'), {$id_pessoa})");
        }
        catch(PDOException $e) {}
    }

    public function __destruct()
    {
        try {
            $conn = Connection::getConnection();
            $stmt = $conn->query("SELECT id_pessoa FROM pessoa WHERE rg = '123456789'");
            $stmt->execute();
            $fetch = $stmt->fetch();
            if(isset($fetch["id_pessoa"])) {
                $id_pessoa = $fetch["id_pessoa"];
                $conn->query("DELETE FROM orientador WHERE id_pessoa = {$id_pessoa}");
                $conn->query("DELETE FROM pessoa WHERE id_pessoa = {$id_pessoa}");
            }
        }
        catch(PDOException $e) {}
    }

    public function testLoginEmailInvalido()
    {
        $this->expectException(IncorrectLoginException::class);

        (new Autentication())->login("email_invalido@example.com", "senha_qualquer");
    }
    
    public function testLoginSenhaInvalida()
    {
        $this->expectException(IncorrectLoginException::class);

        (new Autentication())->login("email_valido@example.com", "senha_invalida");
    }

    public function testLoginParametrosValidos()
    {
        $result = (new Autentication())->login("email_valido@example.com", "senha_valida");

        $this->assertTrue(is_subclass_of($result, "Orientando") || is_subclass_of($result, "Orientador"));
    }
}
