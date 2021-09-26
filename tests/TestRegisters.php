<?php
use App\Models\Connection;


class TestRegisters
{
    public function insertTests()
    {
        $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . "\..");
        $dotenv->load();

        try {
            $conn = Connection::getConnection();

            $conn->query("INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) VALUES ('123456789','12345678901', '1999-12-12', 'Usuario 1', 'email_valido@orientador.com')");
            $id_pessoa = $conn->lastInsertId();
            $conn->query("INSERT INTO orientador (_cpp, user, senha, id_pessoa) VALUES (1,'Usuario 1', MD5('senha_valida'), {$id_pessoa})");
            $id_orientador = $conn->lastInsertId();

            $conn->query("INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) VALUES ('567890123','56789012345', '1999-12-12', 'Usuario 5', 'email_valido@orientador2.com')");
            $id_pessoa = $conn->lastInsertId();
            $conn->query("INSERT INTO orientador (_cpp, user, senha, id_pessoa) VALUES (1,'Usuario 5', MD5('senha_valida'), {$id_pessoa})");
            $id_orientador = $conn->lastInsertId();

            $conn->query("INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) VALUES ('234567890','23456789012', '1999-12-12', 'Usuario 2', 'email_valido@orientando.com')");
            $id_pessoa = $conn->lastInsertId();
            $conn->query("INSERT INTO orientando (user, senha, id_pessoa, id_orientador) VALUES ('Usuario 2', MD5('senha_valida'), {$id_pessoa}, {$id_orientador})");

            $conn->query("INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) VALUES ('345678901','34567890123', '1999-12-12', 'Usuario 3', 'email_valido@novo_orientador.com')");

            $conn->query("INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) VALUES ('456789012','45678901234', '1999-12-12', 'Usuario 4', 'email_valido@novo_orientando.com')");
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

    public function deleteTests()
    {
        $this->deletePersonWhereRg("123456789");
        $this->deletePersonWhereRg("234567890");
        $this->deletePersonWhereRg("345678901");
        $this->deletePersonWhereRg("456789012");
        $this->deletePersonWhereRg("567890123");
    }
}