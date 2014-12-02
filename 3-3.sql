SELECT MAX(Calc_racio.racio) as Max_racio 
FROM (SELECT MAX(lance.valor)/leilao.valorbase AS racio,leilaor.lid 
		FROM concorrente, leilaor, leilao, lance 
		WHERE lance.leilao = leilaor.lid 
		AND leilao.nrleilaonodia = leilaor.nrleilaonodia
		GROUP BY leilaor.lid) AS Calc_racio