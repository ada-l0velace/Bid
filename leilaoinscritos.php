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
	$result = $lei_inscritos->execute();
	//$result = $connection->query($sql);
	$teste = false;
	foreach($lei_inscritos as $row1)
		$teste = true;
	$result = $lei_inscritos->execute();

	if($teste == true){
		echo("<table border=\"1\">\n");
		echo("<tr><td>NrDoDia</td><td>Nome Leilao</td><td>Dia</td></tr>\n");
		$idleilao = 0;
		foreach($lei_inscritos as $row){
			echo("<tr><td>");
			echo($row["lid"]); echo("</td><td>");
			echo($row["nome"]); echo("</td><td>");
			echo($row["dia"]); echo("</td></tr>");
		}
	}
	//session_destroy();
?>