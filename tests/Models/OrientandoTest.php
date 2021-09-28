<?php

use \PHPUnit\Framework\TestCase;
use App\Models\Orientando;
use App\Models\Connection;
use App\Utils\Errors\ConfirmPasswordException;
use App\Utils\Errors\CheckEmailException;
use App\Utils\Errors\PersonAlreadyUsedException;


class OrientandoTest extends TestCase{
    public function __construct(){
        parent::__construct();

        (new TestRegisters())->insertTests();
    }

    public function __destruct(){
        (new TestRegisters())->deleteTests();
    }

    private function getIdOrientador()
    {        
        $conn = Connection::getConnection();
        $stmt = $conn->query("SELECT id_orientador FROM orientador WHERE user = 'Usuário 1'");
        $stmt->execute();
        var_dump("Erro em OrientandoTest::getIdOrientador: " . $stmt->errorCode());
        return $stmt->fetch()["id_orientador"];
    }
    
    public function testOrientandoSenhasDiferentes() { 
        $result = (new Orientando("id","name","type"))->cadastro("nome", "email_valido@example.com", "senha_valida", "senha_qualquer", "tanto_faz");

        $this->assertEquals(ConfirmPasswordException::class, $result::class);
    }

    public function testOrientandoEmailInvalido() {
        $result = (new Orientando("id","name","type"))->cadastro("nome", "email_invalido@example.com", "senha_qualquer", "senha_qualquer", "tanto_faz");
    
        $this->assertEquals(CheckEmailException::class, $result::class);
    }
    
    public function testOrientandoParametrosValidos() {
        $id_orientador =  $this->getIdOrientador();
        $result = (new Orientando("id","name","type"))->cadastro("nome", "email_valido@novo_orientador.com", "senha_valida", "senha_valida", $id_orientador);
    
        $this->assertTrue($result);        
    }

    public function testOrientandoJaExiste() {
        $id_orientador =  $this->getIdOrientador();
        $result = (new Orientando("id","name","type"))->cadastro("nome", "email_valido@orientando.com", "senha_qualquer", "senha_qualquer", $id_orientador);
    
        $this->assertEquals(PersonAlreadyUsedException::class, $result::class);
    }
}