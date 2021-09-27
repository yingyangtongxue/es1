-- PROCEDURE para salvar a avaliação
CREATE PROCEDURE salvarAvaliacaoOrientador (id int, opcao tinyint, comentario varchar(500))
BEGIN
	DECLARE val date;
    DECLARE dataAtual date;
    SELECT dataInicio INTO val FROM avaliacao WHERE id_aval = id;
    SET dataAtual = CAST( NOW() AS Date );
    CASE
    WHEN val IS NULL THEN
    	UPDATE avaliacao
        SET id_avalOpcao = opcao, descricao = comentario, dataInicio = dataAtual WHERE id_aval = id;
    ELSE
    	UPDATE avaliacao
        SET id_avalOpcao = opcao, descricao = comentario WHERE id_aval = id;
    END CASE;
END;

-- PROCEDURE para salvar a avaliação da ccp 
CREATE PROCEDURE salvarAvaliacaoCPP (id_av int, opcao tinyint, comentario varchar(500), id_cpp int)
BEGIN
	DECLARE val date;
    DECLARE dataAtual date;
    SELECT dataInicio INTO val FROM avaliacao WHERE id_aval = id_av;
    SET dataAtual = CAST( NOW() AS Date );
    CASE
    WHEN val IS NULL THEN
    	UPDATE avaliacao
        SET id_avalOpcao = opcao, descricao = comentario, dataInicio = dataAtual, id_orientador = id_cpp WHERE id_aval = id_av;
    ELSE
    	UPDATE avaliacao
        SET id_avalOpcao = opcao, descricao = comentario WHERE id_aval = id_av;
    END CASE;
END;

-- PROCEDURE para enviar a avaliação para a CCP
CREATE PROCEDURE enviarAvaliacaoOrientador (id int, opcao tinyint, comentario varchar(500))
BEGIN
    DECLARE relatorio INT;
    DECLARE dataAtual date;
    SET dataAtual = CAST( NOW() AS Date );
    UPDATE avaliacao SET dataAval = dataAtual WHERE id_aval = id;
    SELECT id_relatorio INTO relatorio FROM avaliacao WHERE id_aval = id;
    INSERT INTO avaliacao (id_avalOpcao, id_aval_pai, id_relatorio)
        VALUES (4, id, relatorio);
    CALL salvarAvaliacaoOrientador(id, opcao, comentario);
END;

-- PROCEDURE para a CPP dar o parecer final
CREATE PROCEDURE enviarAvaliacaoCPP (id_av int, opcao tinyint, comentario varchar(500), id_cpp int)
BEGIN
    DECLARE dataAtual date;
    SET dataAtual = CAST( NOW() AS Date );
    UPDATE avaliacao SET dataAval = dataAtual WHERE id_aval = id_av;
    CALL salvarAvaliacaoCPP(id_av, opcao, comentario, id_cpp);
END;

-- PROCEDURE para iniciar elaboração
CREATE FUNCTION iniciarElaboracao (id_ori int)
RETURNS varchar(100)
BEGIN
    DECLARE dataAtual DATETIME;
    DECLARE msg varchar(100);
    DECLARE flag int;
    DECLARE relatorio int;
    DECLARE periodo int;
    SET dataAtual = NOW();
    SET msg = '';
    SET periodo = 0;
    SET flag = 0;
    SELECT id_periodo INTO periodo
        FROM periodo 
        WHERE _aberto = 1 AND dataAtual between dataInicio and dataTermino
        ORDER BY id_periodo DESC LIMIT 1;
    CASE 
        WHEN periodo = 0 THEN
            SET msg = 'Fora do período de envio de relatórios!';
        ELSE
            SELECT e.id_relatorio INTO flag
                FROM relatorio as r
                    inner join elaboracao as e
                    on r.id_relatorio = e.id_relatorio
                        inner join orientando as a
                        on e.id_orientando = a.id_orientando
                WHERE r.id_periodo = periodo AND a.id_orientando = id_ori;
            CASE 
                WHEN flag != 0 THEN
                    SET msg = 'Relatório já criado/enviado neste período!';
                ELSE
                    SET msg = '';
            END CASE;
    END CASE;
    RETURN msg;
END;

-- PROCEDURE para salvar e enviar elaboração
CREATE PROCEDURE enviarElaboracao (id_ori int, comentario varchar(500), caminho varchar(200))
BEGIN
    DECLARE dataHoraAtual DATETIME;
    DECLARE dataAtual Date;
    DECLARE periodo int;
    DECLARE relatorio int;
    DECLARE orientador int;
    DECLARE usuario varchar(50);
    SET dataHoraAtual = NOW();
    SET dataAtual = CAST(dataHoraAtual as date);
    SELECT id_periodo INTO periodo
        FROM periodo 
        WHERE _aberto = 1 AND dataHoraAtual between dataInicio and dataTermino
        ORDER BY id_periodo DESC LIMIT 1;
    SELECT orientando.id_orientador, orientando.user INTO orientador, usuario FROM orientando WHERE id_orientando = id_ori;
    SET caminho = CONCAT('docs/reports/', caminho, '_' , usuario, '_' , DATE_FORMAT(dataAtual, "%d-%m-%Y") , '.pdf');
    INSERT INTO relatorio (caminho, id_periodo) VALUES (caminho, periodo);
    SELECT id_relatorio INTO relatorio
        FROM relatorio 
        WHERE id_periodo = periodo AND caminho = caminho
        ORDER BY id_relatorio DESC LIMIT 1;
    INSERT INTO elaboracao (dataEnvio, descricao, dataInicio, id_orientando, id_relatorio)
        VALUES (dataAtual, comentario, dataAtual, id_ori, relatorio);
    INSERT INTO avaliacao (id_avalOpcao, id_relatorio, id_orientador)
        VALUES (4, relatorio, orientador);
END;

-- PROCEDURE para fechar um período aberto
CREATE PROCEDURE fecharPeriodo()
BEGIN
    DECLARE dataHoraAtual DATETIME;
    DECLARE id_peri int;
    DECLARE teste int;
    SET dataHoraAtual = NOW();
    SELECT id_periodo INTO id_peri
        FROM periodo 
        WHERE _aberto = 1 AND dataHoraAtual between dataInicio and dataTermino
        ORDER BY id_periodo DESC LIMIT 1;
    UPDATE avaliacao SET id_avalOpcao = 3 WHERE id_avalOpcao = 4 OR id_avalOpcao IS NULL;
    UPDATE periodo set _aberto = 0 where id_periodo = id_peri;
END;