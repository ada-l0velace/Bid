<?php
	include 'includes/dbconnection.php';
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
	$lei_inscritos = $connection->prepare("SELECT leilao.nome, leilao.dia, leilaor.lid 
				FROM concorrente, leilaor, leilao 
				WHERE leilaor.lid = concorrente.leilao 
				AND leilao.nif = leilaor.nif  
				AND concorrente.pessoa = :username 
				AND leilao.dia = leilaor.dia 
				AND leilao.nrleilaonodia = leilaor.nrleilaonodia"); 
	$lei_inscritos->bindParam(':username', $username);
	// setting fetch mode for reusing data without requerying
	$lei_inscritos->setFetchMode(PDO::FETCH_ASSOC);
	$result = $lei_inscritos->execute();
	// setting data for reusing
	$lei_inscritos = $lei_inscritos->fetchALL();

	//check if query returned rows
	$teste = false;
	foreach($lei_inscritos as $row1)
		$teste = true;

	//if contains rows draw table
	if($teste == true){
		echo("<div style='width:50%'><table class='table table-hover table-bordered' border = '1'>\n");
		echo("<thead><tr class='active'><th>NrDoDia</th><th>Nome Leilao</th><th>Dia</th></tr></thead>\n");
		$idleilao = 0;
		foreach($lei_inscritos as $row){
			echo("<tr><td>");
			echo($row["lid"]); echo("</td><td>");
			echo($row["nome"]); echo("</td><td>");
			echo($row["dia"]); echo("</td></tr>");
		}
		echo("</table></div>\n");
	}
	//session_destroy();
?>