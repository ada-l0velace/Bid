SELECT DISTINCT least(a.nif, b.nif) as PessoaA, greatest(a.nif, b.nif) as PessoaB
from pessoac as a, pessoac as b
where a.capitalsocial = b.capitalsocial and a.nif != b.nif