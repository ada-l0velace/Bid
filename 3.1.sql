SELECT concorrente.pessoa, concorrente.leilao
FROM concorrente
WHERE (concorrente.pessoa, concorrente.leilao) NOT IN ( SELECT lance.pessoa, lance.leilao 
														FROM lance)