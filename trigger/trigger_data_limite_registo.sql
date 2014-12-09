DELIMITER //
DROP TRIGGER IF EXISTS `data_limite_registo` //
CREATE TRIGGER data_limite_registo BEFORE INSERT ON concorrente FOR EACH ROW BEGIN
    DECLARE dia_leilao date;
    DECLARE nr_dias_leilao integer;
    
    (SELECT dia, nrdias INTO dia_leilao, nr_dias_leilao FROM leilaor 
		WHERE lid = new.leilao);
    
	IF CURDATE() NOT BETWEEN dia_leilao AND (dia_leilao + nr_dias_leilao) THEN
		CALL `'' O Leilao esta indisponivel (data invalida) ''`;
	END IF;
  END;
// 
DELIMITER ;