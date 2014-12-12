SELECT concorrente.pessoa, concorrente.leilao
FROM concorrente
WHERE (concorrente.pessoa) NOT IN (SELECT lance.pessoa 
														FROM lance)  