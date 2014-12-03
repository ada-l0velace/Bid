DELIMITER //

CREATE TRIGGER testref BEFORE INSERT ON lance FOR EACH ROW BEGIN
	DECLARE base_licitacao integer;
    DECLARE max_valor_licitacao integer;
    DECLARE n_ha_licitacao integer;
    
    SET n_ha_licitacao =
		(SELECT COUNT( * ) AS max_valor
				FROM lance 
				WHERE lance.leilao = new.leilao);
    
    IF n_ha_licitacao = 0 	THEN 
		SET base_licitacao = 
			(SELECT leilao.valorbase FROM leilao, leilaor 
			WHERE leilaor.lid = new.leilao
				and leilao.dia = leilaor.dia and leilao.nif = leilaor.nif and leilao.nrleilaonodia = leilaor.nrleilaonodia);
                
		IF new.valor < base_licitacao THEN 
			CALL `'O Lance é inferior ao Lance Mínimo premitido!'`;
		END IF;
	
    ELSE
		SET max_valor_licitacao =
			(SELECT MAX(lance.valor) AS max_valor
			FROM concorrente, leilaor, leilao, lance 
			WHERE lance.leilao = leilaor.lid 
			AND leilao.nrleilaonodia = leilaor.nrleilaonodia
			AND concorrente.pessoa IN (SELECT concorrente.pessoa 
								FROM concorrente 
								WHERE concorrente.leilao = leilaor.lid 
								AND concorrente.pessoa = new.pessoa)
				GROUP BY leilaor.lid);
	
		IF new.valor <= max_valor_licitacao THEN 
			CALL `'O Lance é inferior ao Maior Lance !'`;
    	END IF;
	END IF;
  END; 
// 
DELIMITER ;