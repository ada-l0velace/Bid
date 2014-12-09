

DROP TABLE IF EXISTS tblfacts;
CREATE TABLE tblfacts (
	max_lance				INT NOT NULL,
	nif_pessoa				INT NOT NULL,
	lei_diasr				INT NOT NULL,
	lei_nome				CHAR(80),
	lei_id 					INT NOT NULL,
	data_id 				INT NOT NULL,
	region_id 				INT NOT NULL,
	#PRIMARY KEY (data_id,region_id),
	FOREIGN KEY (data_id)  REFERENCES Dates_D(date_id),
	FOREIGN KEY (region_id)  REFERENCES NUTS_D(region_id));

INSERT INTO tblfacts( max_lance,nif_pessoa,lei_diasr,lei_nome,lei_id, data_id, region_id )
SELECT MAX(t1.valor) as max_valor,
						t1.pessoa,
						DATEDIFF(t1.dia+t1.nrdias,CURDATE()) as dias,
						t1.nome,
						t1.lid,
						(SELECT date_id FROM Dates_D WHERE date = DATE_FORMAT( t1.dia , '%Y-%m-%d' )) as dia,
						(SELECT NUTS_D.region_id FROM NUTS_D WHERE NUTS_D.concelho = t1.concelho AND NUTS_D.nuts_III = t1.regiao) as regiao FROM (
		SELECT leilao.nome, leilao.dia, lance.pessoa , leilaor.lid, lance.valor ,leilaor.nrdias,leiloeira.concelho,leiloeira.regiao
		FROM concorrente, leilaor, leilao, lance, leiloeira
		WHERE 
		/* lance foreign keys*/
		lance.leilao = concorrente.leilao
		AND lance.pessoa = concorrente.pessoa
		/*-------------*/
		/* leilaor foreign keys*/
		AND leilaor.nrleilaonodia = leilao.nrleilaonodia
		AND leilaor.nif = leilao.nif
		AND leilaor.dia = leilao.dia
		/*--------------*/
		/*concorrent foreign keys */
		AND concorrente.leilao = leilaor.lid
		/*--------------*/

		/* leilao foreign keys */
		AND leilao.nif = leiloeira.nif
		/*-------------*/
		ORDER BY lance.valor DESC) AS t1
GROUP BY t1.lid


#(SELECT NUTS_D.region_id FROM NUTS_D WHERE NUTS_D.concelho = t1.concelho AND NUTS_D.nuts_III = t1.region) as region
/*
SELECT FLOOR(60 + RAND() * 61), Dates_D.date_id, region_id
FROM Dates_D,NUTS_D,leiloeira
WHERE date = DATE_FORMAT( curdate() , '%Y-%m-%d' )
AND NUTS_D.concelho = leiloeira.concelho
*/

