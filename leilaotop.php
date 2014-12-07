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

	$leilaotop = $connection->prepare("SELECT MAX(t1.valor) as max_valor,t1.pessoa,t1.nrdias,t1.t1.dia,t1.nome,t1.lid FROM (
												SELECT leilao.nome, leilao.dia, lance.pessoa , leilaor.lid, lance.valor ,leilaor.nrdias
													FROM concorrente, leilaor, leilao, lance 
													WHERE 
													/* lance foreign keys*/
													lance.leilao = concorrente.leilao
													AND lance.pessoa = concorrente.pessoa
													/*-------------*/
													/* leilaor foreign keys*/
													AND leilaor.nrleilaonodia = leilao.nrleilaonodia
													AND leilaor.nif = leilao.nif
													AND leilaor.dia = leilao.dia
													/*--------------*/
											        /*AND concorrente.pessoa IN (SELECT concorrente.pessoa 
											        							FROM concorrente 
											        							WHERE concorrente.leilao = leilaor.lid 
											        							AND concorrente.pessoa = :username)*/

													/*concorrent foreign keys */
													AND (leilaor.dia + leilaor.nrdias) >= CURDATE()
													AND concorrente.leilao = leilaor.lid
													/*--------------*/
													ORDER BY lance.valor DESC) AS t1
												WHERE :username in (SELECT concorrente.pessoa 
											        							FROM concorrente 
											        							WHERE concorrente.leilao = t1.lid)
												GROUP BY t1.lid
												"); 
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
			echo($row["lid"]); echo("</td><td>");
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