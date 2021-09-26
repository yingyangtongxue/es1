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
    
    public function testOrientandoSenhasDiferentes() { 
        $result = (new Orientando("id","name","type"))->cadastro("nome", "email_valido@example.com", "senha_valida", "senha_qualquer", "tanto_faz");

        $this->assertEquals(ConfirmPasswordException::class, $result::class);
    }

    public function testOrientandoEmailInvalido() {
        $result = (new Orientando("id","name","type"))->cadastro("nome", "email_invalido@example.com", "senha_qualquer", "senha_qualquer", "tanto_faz");
    
        $this->assertEquals(CheckEmailException::class, $result::class);
    }
    /*
//problemas nas duas
    public function testOrientandoParametrosValidos() {
        $result = (new Orientando("id","name","type"))->cadastro("nome", "email_valido@example.com", "senha_valida", "senha_valida", "tanto_faz");
    
        $this->assertEquals(cadastro::class, $result::class);        
    }

    public function testOrientandoJaExiste() {
        $result = (new Orientando("id","name","type"))->cadastro("nome", "email_ja_cadastrado@example.com", "senha_qualquer", "senha_qualquer", "tanto_faz");
    
        $this->assertEquals(PersonAlreadyUsedException::class, $result::class);
    }*/
}