DELIMITER //

CREATE TRIGGER testref BEFORE INSERT ON lance FOR EACH ROW BEGIN
	DECLARE base_licitacao integer;
	SET base_licitacao = 
		(SELECT leilao.valorbase FROM leilao, leilaor 
		WHERE leilaor.lid = new.leilao
			and leilao.dia = leilaor.dia and leilao.nif = leilaor.nif and leilao.nrleilaonodia = leilaor.nrleilaonodia);
	IF new.valor <= base_licitacao THEN 
		CALL `'O Lance é inferior ao Lance Mínimo premitido!'`;
    END IF;
  END; 
// 
DELIMITER ;