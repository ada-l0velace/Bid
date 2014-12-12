DROP TABLE IF EXISTS tblfacts;
DROP TABLE IF EXISTS Dates_D;
CREATE TABLE Dates_D (
date_id          INT PRIMARY KEY AUTO_INCREMENT,
date             DATE NOT NULL,
day_of_month     INT,
day_of_year      INT,
month            CHAR(10),
year             INT,
UNIQUE KEY `date` (`date`));

INSERT INTO Dates_D (date)
SELECT DISTINCT DATE_FORMAT( dia, '%Y-%m-%d' ) as data
FROM leilao;

UPDATE Dates_D SET
day_of_month    = DATE_FORMAT( date, "%d" ),
day_of_year     = DATE_FORMAT( date, "%j" ),
day_of_month    = DATE_FORMAT( date, "%d" ),
month           = DATE_FORMAT( date, "%M"),
year            = DATE_FORMAT( date, "%Y" );

DROP TABLE IF EXISTS NUTS_D;
CREATE TABLE NUTS_D (
region_id			INT AUTO_INCREMENT,
nuts_III          CHAR(50),
concelho     CHAR(50),

PRIMARY KEY(region_id));
INSERT INTO NUTS_D (nuts_III,concelho)
SELECT DISTINCT regiao,concelho
FROM leiloeira

/*source /var/www/Base-de-Dados/big_scripts/region.sql;*/