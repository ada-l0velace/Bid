SELECT 
    leilao.nrleilaonodia,
    leilao.dia,
    leilao.nif
FROM
    lance,
    leilao,
    leilaor
WHERE
    leilao.nif = leilaor.nif
        AND leilaor.lid = lance.leilao
        AND leilao.nrleilaonodia = leilaor.nrleilaonodia
        AND leilao.dia = leilaor.dia
        AND lance.valor / leilao.valorbase = (SELECT 
            MAX(lance.valor / leilao.valorbase)
        FROM
            leilao,
            lance,
            leilaor
        WHERE
            leilaor.lid = lance.leilao
                AND leilao.nrleilaonodia = leilaor.nrleilaonodia
                AND leilao.dia = leilaor.dia
                AND leilao.nif = leilaor.nif)