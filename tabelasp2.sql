-- define como terminador de comandos o caracter ;
DELIMITER ;

-- desativa a verificaÃ§Ãµ das chaves estrangeiras
SET foreign_key_checks = 0 ;

-- tabela das pessoas 
DROP TABLE IF EXISTS pessoa ;
CREATE TABLE pessoa( 
	nif 			INT ,    					-- ID e username das pessoas pessoa
	nome  			VARCHAR(80) NOT NULL,			
	pin     		INT NOT NULL, 	 			-- codigo de acesso desta pessoa (pin ou passwd)
	PRIMARY KEY (nif)
);

-- tabela das pessoas coletivas 
DROP TABLE IF EXISTS pessoac;
CREATE TABLE pessoac( 
	nif 			INT, 
	capitalsocial 	INT NOT NULL,
	PRIMARY KEY (nif),
	FOREIGN KEY (nif)  REFERENCES pessoa(nif)
);

-- tabela das leiloeiras 
DROP TABLE IF EXISTS leiloeira;
CREATE TABLE leiloeira( 
	nif 			INT, 
	nralvara 		INT NOT NULL,
	concelho 		VARCHAR (80) NULL,
	regiao 			VARCHAR (80) NULL,
	PRIMARY KEY (nif),
	FOREIGN KEY (nif)  REFERENCES pessoac(nif)
);

-- tabela dos leilÃµes
DROP TABLE IF EXISTS leilao;
CREATE TABLE leilao( 
	dia				DATE, 		-- dia  em que o leilÃ£o se realiza
	nrleilaonodia	INT ,      		-- Contador diarios de leilÃµes: vale 1 para o 1Âº leilÃ£o do dia, 2 para o 2Âº leilÃ£o do dia etc.
	nif 			INT , 
	nome   		 	VARCHAR (80) NULL, 	-- Nome (da Ã¡rea de concessÃ£o do recurso ou da Ã¡rea de exploraÃ§Ã£o de infraestrutura) a ser leiloada neste leilÃ£o
	valorbase		INT NOT NULL, 		-- Valor de base do leiÃ£o.
	tipo			BOOLEAN NOT NULL,	-- Tipo de leilÃ£o .
											-- TRUE = leilao de Ã¡rea de concessÃ£o de recursos, 
											-- FALSE = leilao de area de exploracao de infraestrutura
	PRIMARY KEY (nif,dia,nrleilaonodia),
	FOREIGN KEY (nif)  REFERENCES leiloeira(nif)
);

-- tabela dos leilÃµes de Recursos 
DROP TABLE IF EXISTS leilaor;
CREATE TABLE leilaor( 
	dia					DATE NOT NULL,		-- dia em que po leilÃ£o abre (desde a hora 00:00:00) 
	nrleilaonodia		INT NOT NULL,
	nif 				INT NOT NULL, 	
	nrdias				INT NOT NULL, 		-- nr de dias em que  leilÃ£o estÃ¡ aberto
	lid					INT AUTO_INCREMENT, 
	FOREIGN KEY (nif,dia,nrleilaonodia)  REFERENCES leilao(nif,dia,nrleilaonodia),
	PRIMARY KEY (nif,dia,nrleilaonodia),
	UNIQUE KEY(lid)
);

-- tabela com os  concorrentes registados aos leilÃµes de Recursos 
DROP TABLE IF EXISTS concorrente;
CREATE TABLE concorrente( 
	pessoa				INT NOT NULL, 
	leilao 				INT NOT NULL, 	
	PRIMARY KEY (pessoa,leilao),
	FOREIGN KEY (pessoa)  REFERENCES pessoa(nif),
	FOREIGN KEY (leilao)  REFERENCES leilaor(lid)
);

-- tabela com os lances dos concorrentes aos  leilÃµes de Recursos 
DROP TABLE IF EXISTS lance;
CREATE TABLE lance( 
	pessoa				INT NOT NULL, 
	leilao 				INT NOT NULL,
	valor 				INT NOT NULL, 	-- valor de cada lance 
	PRIMARY KEY (pessoa,leilao,valor),
	FOREIGN KEY (pessoa,leilao)  REFERENCES concorrente(pessoa,leilao)
);

insert into pessoa	values ('100',	'Alberto',		'11');
insert into pessoa	values ('200',	'Manel',		'22');
insert into pessoa	values ('300',	'Ana',		    '33');
insert into pessoa	values ('400',	'Samsung',		'44');
insert into pessoa	values ('500',	'Apple',		'55');
insert into pessoa	values ('600',	'Leiloeira6',	'66');
insert into pessoa  values ('700',  'Leiloeira7',   '77');

insert into pessoac values ('400',	'500000');
insert into pessoac values ('500',	'700000');

insert into leiloeira values ('600',  '666',   'Loures',   'Lisboa');
insert into leiloeira values ('700',  '777',   'Elvas',    'Alentejo');

insert into leilao values ('2014-11-18', '1', '600', 'ACMetal',    '900',   '1');
insert into leilao values ('2014-11-17', '2', '600', 'ACMadeira',  '450',   '1');
insert into leilao values ('2014-11-18', '1', '700', 'ACCobre',    '1000',  '1');
insert into leilao values ('2013-11-19', '1', '700', 'ACCristal',  '100',   '1');
insert into leilao values ('2015-01-01', '1', '700', 'ACMarmore',  '250',   '1');

insert into leilaor values ('2014-11-18', '1', '600', '1',   '1');
insert into leilaor values ('2014-11-17', '2', '600', '5',   '2');
insert into leilaor values ('2014-11-18', '1', '700', '1',   '3');
insert into leilaor values ('2013-11-19', '1', '700', '50',  '4');
insert into leilaor values ('2015-01-01', '1', '700', '365', '5');

-- ativa a verificaÃ§Ãµ das chaves estrangeiras
SET foreign_key_checks = 1 ;
