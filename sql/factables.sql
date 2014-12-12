DROP TABLE IF EXISTS tblfacts;
CREATE TABLE tblfacts (
	max_lance				INT NOT NULL,
	lei_id 					INT NOT NULL,
	data_id 				INT NOT NULL,
	region_id 				INT NOT NULL,
	PRIMARY KEY (lei_id, data_id, region_id),
	FOREIGN KEY (data_id)  REFERENCES Dates_D(date_id),
	FOREIGN KEY (region_id)  REFERENCES NUTS_D(region_id));

INSERT INTO tblfacts( max_lance,lei_id, data_id, region_id )
SELECT 
	lance.valor,
	lance.leilao,
	(SELECT date_id FROM Dates_D WHERE date = DATE_FORMAT( leilao.dia , '%Y-%m-%d' )) as dia,
	(SELECT NUTS_D.region_id FROM NUTS_D WHERE NUTS_D.concelho = leiloeira.concelho AND NUTS_D.nuts_III = leiloeira.regiao) as regiao
FROM
	lance,
	leilao,
	leilaor,
	leiloeira,
	(SELECT 
		MAX(lance.valor) AS max_la, lance.leilao
		FROM
			lance
		GROUP BY lance.leilao) AS tab
WHERE
	lance.leilao = tab.leilao
		AND lance.valor = tab.max_la
		AND leilao.nif = leilaor.nif
		AND leilaor.lid = lance.leilao
		AND leilao.nrleilaonodia = leilaor.nrleilaonodia
		AND leilaor.dia = leilao.dia
		AND leilao.dia = leilaor.dia
		AND leiloeira.nif = leilao.nif