<?php 
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		// Variáveis de conexão à BD
		$host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
		$user="*"; // -> substituir pelo nome de utilizador
		$password="*"; // -> substituir pela password dada pelo mysql_reset
		$dbname = $user; // a BD tem nome identico ao utilizador
		#echo("<p>Projeto Base de Dados Parte II</p>\n");
		$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password, 
		array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		if ($connection->errorCode()) {
		    die("Connection failed: " . $connection->errorCode());
		} 
		#echo("<p>Connected to MySQL database $dbname on $host as user $user</p>\n");
		?>

		
