SELECT pessoa.nome, concorrente.pessoa, COUNT(concorrente.pessoa) AS n_leiloes
FROM concorrente, pessoa, pessoac
WHERE pessoa.nif = pessoac.nif
AND concorrente.pessoa = pessoa.nif
GROUP BY concorrente.pessoa
HAVING COUNT(concorrente.pessoa) = 2;