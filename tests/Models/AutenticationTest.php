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

        (new TestRegisters())->insertTests();
    }

    public function __destruct()
    {
        (new TestRegisters())->deleteTests();
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
