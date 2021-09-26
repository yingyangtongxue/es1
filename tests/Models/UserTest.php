<?php
use \PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Models\Orientador;
use App\Models\Orientando;
use App\Models\Connection;


class UserTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();

        (new TestRegisters())->insertTests();
    }

    public function __destruct()
    {
        (new TestRegisters())->deleteTests();
    }

    private function sendLogin(string $email, string $pwd)
    {
        $_POST['email'] = $email;
        $_POST['password'] = $pwd;

        @User::login();
    }

    public function testEmailIncorretoSenhaQualquer()
    {
        $this->sendLogin("email_invalido@orientador.com", "senha_qualquer");

        $this->assertEquals($_SESSION["error"], "O email ou senha estão incorretos !!!");
    }

    public function testEmailCorretoSenhaIncorreto()
    {
        $this->sendLogin("email_valido@orientador.com", "senha_invalida");

        $this->assertEquals($_SESSION["error"], "O email ou senha estão incorretos !!!");
    }

    public function testEmailSenhaCorretos()
    {
        $this->sendLogin("email_valido@orientador.com", "senha_valida");

        $this->assertEquals($_SESSION["userName"], "Usuario 1");
        $this->assertEquals($_SESSION["userType"], "CCP");
    }
}