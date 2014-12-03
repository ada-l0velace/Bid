<html>
	<body>

	<?php 
		include 'includes/dbconnection.php';
		// inicia sessão para passar variaveis entre ficheiros php
		session_start();
		// Função para limpar os dados de entrada
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		//asdfasdfsadf
		// Carregamento das variáveis username e pin do form HTML através do metodo POST;
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$username = test_input($_POST["username"]);
			$pin = test_input($_POST["pin"]);
		}
		echo("<p>Valida Pin da Pessoa $username</p>\n");
		

		// obtem o pin da tabela pessoa
		$sql = "SELECT * FROM pessoa WHERE nif=:username";
		$pessoa = $connection->prepare($sql);
		$pessoa->bindParam(':username', $username);
		$result = $pessoa->execute();
		if (!$result) {
			echo("<p> Erro na Query:($sql)<p>");
			exit();
		}
		foreach($pessoa as $row){
			$safepin = $row["pin"];
			$nif = $row["nif"];
			echo($row["nome"]);
			$nome = $row["nome"];
		}
		if ($safepin != $pin ) {
			echo "<p>Pin Invalido! Exit!</p>\n";
			$connection = null;
			exit();
		}
		echo "<p>Pin Valido! </p>\n";
		// passa variaveis para a sessao;
		$_SESSION['username'] = $username; 
		$_SESSION['nif'] = $nif;
		// Apresenta os leilões
		$sql = "SELECT * 
				FROM leilao, leilaor 
				WHERE leilaor.nif = leilao.nif 
				AND leilaor.nrleilaonodia = leilao.nrleilaonodia 
				AND leilaor.dia = leilao.dia
				ORDER BY leilaor.lid
				"; 
		$result = $connection->query($sql);
		echo("<table border=\"1\">\n");
		echo("<tr><td>ID</td><td>nif</td><td>dia</td><td>NrDoDia</td><td>nome</td><td>tipo</td><td>valo
		rbase</td></tr>\n");
		foreach($result as $row){
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
	?>

	<form action="leilao.php" method="post">
		<h2>Escolha o ID do leilao que pretende concorrer</h2>
		<p>ID : <input type="text" name="lid" /></p>
		<p><input type="submit" /></p>
	</form>

	<form action="lance.php" method="post">
		<h2>Escolha o ID do leilao que pretende concorrer e quanto quer licitar</h2>
		<p>ID : <input type="text" name="lid" /></p>
		<p>Lance : <input type="text" name="lance" /></p>
		<p><input type="submit" /></p>
	</form>

	<?php 
		$sql = $connection->prepare("SELECT leilao.nome, leilao.dia, leilaor.lid 
				FROM concorrente, leilaor, leilao 
				WHERE leilaor.lid = concorrente.leilao 
				AND leilao.nif = leilaor.nif  
				AND concorrente.pessoa = :username 
				AND leilao.dia = leilaor.dia 
				AND leilao.nrleilaonodia = leilaor.nrleilaonodia"); 
		$sql->bindParam(':username', $username);
		$result = $sql->execute();
		//$result = $connection->query($sql);
		$teste = false;
		foreach($sql as $row1){
			$teste = true;
		}
		$result = $sql->execute();

		if($teste == true){
			echo("<table border=\"1\">\n");
			echo("<tr><td>NrDoDia</td><td>Nome Leilao</td><td>Dia</td></tr>\n");
			$idleilao = 0;
			foreach($sql as $row){
				echo("<tr><td>");
				echo($row["lid"]); echo("</td><td>");
				echo($row["nome"]); echo("</td><td>");
				echo($row["dia"]); echo("</td></tr>");
			}
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
		?>

	</body>
</html>
