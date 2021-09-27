-- Setando Timezone correta (Brasil/São Paulo)
SET @@global.time_zone = '+03:00';
SET GLOBAL time_zone = '+3:00';

-- Inserindo Pessoas (Esta seção pode ser modificada)
INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) 
    VALUES ('000000000','00000000000', '2000-01-01', 'Pessoa 0', 'email0@email.br');
INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) 
    VALUES ('111111111','11111111111', '2000-02-02', 'Pessoa 1', 'email1@email.br');
INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) 
    VALUES ('222222222','22222222222', '2000-03-03', 'Pessoa 2', 'email2@email.br');
INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) 
    VALUES ('333333333','33333333333', '2000-04-04', 'Pessoa 3', 'email3@email.br');
INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) 
    VALUES ('444444444','44444444444', '2000-05-05', 'Pessoa 4', 'email4@email.br');
INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) 
    VALUES ('555555555','55555555555', '2000-06-06', 'Pessoa 5', 'email5@email.br');
INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) 
    VALUES ('666666666','66666666666', '2000-07-07', 'Pessoa 6', 'email6@email.br');
INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) 
    VALUES ('777777777','77777777777', '2000-08-08', 'Pessoa 7', 'email7@email.br');
INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) 
    VALUES ('888888888','88888888888', '2000-09-09', 'Pessoa 8', 'email8@email.br');
INSERT INTO pessoa (rg, cpf, dataNasc, nome, email) 
    VALUES ('999999999','99999999999', '2000-10-10', 'Pessoa 9', 'email9@email.br');


-- Setando Avaliações (Não Modifique isso)
INSERT INTO avalOpcao (descricao) VALUES ('ADEQUADO');
INSERT INTO avalOpcao (descricao) VALUES ('ADEQUADO COM RESSALVAS');
INSERT INTO avalOpcao (descricao) VALUES ('INSATISFATÓRIO');
INSERT INTO avalOpcao (descricao) VALUES ('NÃO AVALIADO');

