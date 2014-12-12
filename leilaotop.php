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

	$leilaotop = $connection->prepare("SELECT 
										    lance.valor,
										    lance.pessoa,
										    leilaor.nrdias,
										    leilao.dia,
										    leilao.nome,
										    lance.leilao
										FROM
										    lance,
										    leilao,
										    leilaor,
										    (SELECT 
										        MAX(lance.valor) AS max_la, lance.leilao
										    FROM
										        lance
										    GROUP BY lance.leilao) AS tab
										WHERE
										    lance.leilao = tab.leilao
										        AND leilao.nif = leilaor.nif
										        AND leilaor.lid = lance.leilao
										        AND leilao.nrleilaonodia = leilaor.nrleilaonodia
										        AND leilaor.dia = leilao.dia
										        AND leilao.dia = leilaor.dia
										        AND lance.valor = tab.max_la
										        AND :username IN (SELECT 
										            concorrente.pessoa
										        FROM
										            concorrente
										        WHERE
										            concorrente.leilao = lance.leilao)"); 
	$leilaotop->bindParam(':username', $username);
	// setting fetch mode for reusing data without requerying
	$leilaotop->setFetchMode(PDO::FETCH_ASSOC);
	$result = $leilaotop->execute();
	// setting data for reusing
	$leilaotop = $leilaotop->fetchAll();

	//check if query returned rows
	$hasrows = false;
	foreach($leilaotop as $row1){
		$hasrows = true;
	}
	//if contains rows draw table
	if($hasrows){
		echo("<div style='width:50%'><table class='table table-hover table-bordered' border = '1'>\n");
		echo("<thead><tr><th>Nr Leilao</th><th>Nome Leilao</th><th>Dia</th><th>Termina em:</th><th>Max Valor</th><th>Licitador</th></tr></thead>\n");
		foreach($leilaotop as $row){
			echo("<tr><td>");
			echo($row["leilao"]); echo("</td><td>");
			echo($row["nome"]); echo("</td><td>");
			echo($row["dia"]); echo("</td><td>");
			$data_now = date("y-m-d");
			$time_leilao = strtotime($row["dia"]) ;
			$dia_abertura = date("y-m-d", $time_leilao);
			$new_dia = date("y-m-d", strtotime("+" . $row["nrdias"] . " days", $time_leilao));
			$datediff = strtotime($new_dia) - strtotime($data_now);
			echo(floor($datediff/(60*60*24)). " dia(s)"); echo("</td><td>");
			echo($row["max_valor"]); echo("</td><td>");
			echo($row["pessoa"]);  echo("</td></tr>");
		}
		echo("</table></div>\n");
	}
	//session_destroy();
?>