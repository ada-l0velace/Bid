<?php
	include 'includes/dbconnection.php';
	session_start();
	if(!$_SESSION['username'])
		header("Location: login.php");
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
	$leilaotop = $connection->prepare("SELECT leilao.nome, leilao.dia, leilaor.lid, MAX(lance.valor) AS max_valor,leilaor.nrdias 
												FROM concorrente, leilaor, leilao, lance 
												WHERE lance.leilao = leilaor.lid 
												AND leilao.nrleilaonodia = leilaor.nrleilaonodia
										        AND concorrente.pessoa IN (SELECT concorrente.pessoa 
										        							FROM concorrente 
										        							WHERE concorrente.leilao = leilaor.lid 
										        							AND concorrente.pessoa = :username)
												GROUP BY leilaor.lid"); 
	$leilaotop->bindParam(':username', $username);
	$result = $leilaotop->execute();
	//$result = $connection->query($sql);
	$teste = false;
	foreach($leilaotop as $row1){
		$teste = true;
	}
	$result = $leilaotop->execute();
	if($teste == true){
		echo("<table border=\"1\">\n");
		echo("<tr><td>Nr Leilao</td><td>Nome Leilao</td><td>Dia</td><td>Termina em:</td><td>Max Valor</td></tr>\n");
		foreach($leilaotop as $row){
			echo("<tr><td>");
			echo($row["lid"]); echo("</td><td>");
			echo($row["nome"]); echo("</td><td>");
			echo($row["dia"]); echo("</td><td>");
			$data_now = date("y-m-d");
			$time_leilao = strtotime($row["dia"]) ;
			$dia_abertura = date("y-m-d", $time_leilao);
			$new_dia = date("y-m-d", strtotime("+" . $row["nrdias"] . " days", $time_leilao));
			$datediff = strtotime($new_dia) - strtotime($data_now);
			echo(floor($datediff/(60*60*24)). " dia(s)"); echo("</td><td>");
			echo($row["max_valor"]); echo("</td></tr>");
		}
	}
	//session_destroy();
?>