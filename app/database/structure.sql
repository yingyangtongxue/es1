CREATE DATABASE avaliacao_desempenho;

USE avaliacao_desempenho;

CREATE TABLE pessoa (
    id_pessoa int not null AUTO_INCREMENT,
    rg char(9) not null UNIQUE,
    cpf char(11) not null UNIQUE,
    dataNasc DATE not null,
    nome varchar(70) not null,
    email varchar(100) not null,
    PRIMARY KEY (id_pessoa)
);

CREATE TABLE avalOpcao (
    id_avalOpcao TINYINT not null AUTO_INCREMENT,
    descricao varchar(500) not null,
    PRIMARY KEY (id_avalOpcao)
);

CREATE TABLE orientador (
    id_orientador int not null AUTO_INCREMENT,
    _cpp TINYINT(1) not null,
    user varchar(50) not null UNIQUE,
    senha varchar(80) not null,
    id_pessoa int not null UNIQUE,
    PRIMARY KEY (id_orientador),
    FOREIGN KEY (id_pessoa) references pessoa (id_pessoa)
);

CREATE TABLE orientando (
    id_orientando int not null AUTO_INCREMENT,
    user varchar(50) not null UNIQUE,
    senha varchar(80) not null,
    id_pessoa int not null UNIQUE,
    id_orientador int not null,
    PRIMARY KEY (id_orientando),
    FOREIGN KEY (id_pessoa) references pessoa (id_pessoa),
    FOREIGN KEY (id_orientador) references orientador (id_orientador)
);
CREATE TABLE periodo (
    id_periodo int not null AUTO_INCREMENT,
    dataInicio DATETIME not null,
    dataTermino DATETIME not null,
    _aberto TINYINT(1) not null,
    id_orientador int not null,
    PRIMARY KEY (id_periodo),
    FOREIGN KEY (id_orientador) references orientador (id_orientador)
);

CREATE TABLE relatorio (
    id_relatorio int not null AUTO_INCREMENT,
    caminho varchar(200),
    id_periodo int not null,
    PRIMARY KEY (id_relatorio),
    FOREIGN KEY (id_periodo) references periodo (id_periodo)
);

CREATE TABLE elaboracao (
    id_elaboracao int not null AUTO_INCREMENT,
    dataEnvio date,
    descricao varchar(500),
    dataInicio date not null,
    id_orientando int not null,
    id_relatorio int not null,
    PRIMARY KEY (id_elaboracao),
    FOREIGN KEY (id_orientando) references orientando (id_orientando),
    FOREIGN KEY (id_relatorio) references relatorio (id_relatorio)
);

CREATE TABLE avaliacao (
    id_aval int not null AUTO_INCREMENT,
    id_aval_pai int,
    dataAval date,
    descricao varchar(500),
    dataInicio date,
    id_avalOpcao TINYINT not null,
    id_relatorio int not null,
    id_orientador int,
    PRIMARY KEY (id_aval),
    FOREIGN KEY (id_avalOpcao) references avalOpcao (id_avalOpcao),
    FOREIGN KEY (id_relatorio) references relatorio (id_relatorio),
    FOREIGN KEY (id_orientador) references orientador (id_orientador)
);