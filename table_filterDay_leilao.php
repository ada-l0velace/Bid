<?php 
	include 'includes/dbconnection.php';

	// inicia sessão para passar variaveis entre ficheiros php
	session_start();
	if(!$_SESSION['username']){
		header("Location: login.php");
		exit();
	}
	else{
		$username = $_SESSION['username'];
		$nif = $_SESSION['nif'];
	}
	// Função para limpar os dados de entrada
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data; 
	}
	// Carregamento das variáveis username e pin do form HTML através do metodo POST;
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$dropdown_days = test_input($_POST["dia"]);
	}
	if(!$dropdown_days){

		#echo("<div id='erro'> Ocorreu um erro! </div>");
		exit();
	}
	//filtra a query com a data correspondente...
	try{
		$sql = "SELECT * 
				FROM leilao, leilaor 
				WHERE leilaor.nif = leilao.nif 
				AND leilaor.nrleilaonodia = leilao.nrleilaonodia
				AND leilaor.dia = leilao.dia
				AND leilaor.dia = :dropdown_days
				ORDER BY leilaor.lid
				";
		$result = $connection->prepare($sql);
		$result->bindParam(':dropdown_days', $dropdown_days);
		$result->execute();
		echo("<table id='filter_leilao' border=\"1\">\n");
		echo("<tr><td>ID</td><td>nif</td><td>dia</td><td>NrDoDia</td><td>nome</td><td>tipo</td><td>valo
		rbase</td></tr>\n");
		foreach($result as $row){
			//array_push($array,$row["lid"]);
			echo("<tr><td>");
			echo($row["lid"]); echo("</td><td>");
			echo($row["nif"]); echo("</td><td>");
			echo($row["dia"]); echo("</td><td>");
			echo($row["nrleilaonodia"]); echo("</td><td>");
			echo($row["nome"]); echo("</td><td>");
			echo($row["tipo"]); echo("</td><td>");
			echo($row["valorbase"]); echo("</td></tr>");
			//$leilao[$idleilao]= array($row["nif"],$row["diahora"],$row["nrleilaonodia"]);
		}
		echo("</table>\n");
	}
	catch (Exception $e) {
		// An exception has been thrown
		$error = $e->getmessage();
		echo("<div id='erro'> $error </div>");
		exit();
	}
	?>