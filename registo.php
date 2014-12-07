<html>
	<head>
	<script src="js/jquery-2.1.1.min.js"></script>
	
	<script>

		function populateDivTable(page,divname) {
			$.ajax({
	            url: page,
	            type: "POST",
	            data: "",                   
	            success: function (data) {
	            	document.getElementById(divname).innerHTML = data;
	            }
        	});
		}


	</script>
</head>
	<body>
	<input type="button" value="logout" onclick="location.href = 'logout.php'" />
	<input type="button" value="registo transactions" onclick="location.href = 'registo_transations.php'" />
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
		echo("You are logged with ".$_SESSION['pessoa']);
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

	<form id="leilao" method="post">
		<h2>Escolha o ID do leilao que pretende concorrer</h2>
		<p>ID : <input type="text"  name="lid" /></p>
		<p><input type="submit"  /></p>
	</form>
	<div id="leiloesincritos"></div>
	<form id="lance" method="post">
		<h2>Escolha o ID do leilao que pretende concorrer e quanto quer licitar</h2>
		<p>ID : <input type="text" name="lid" /></p>
		<p>Lance : <input type="text" name="lance" /></p>
		<p><input type="submit"  /></p>
	</form>
	<div id="leiloestop"></div>
	</body>
	<script >
		populateDivTable("leilaoinscritos.php","leiloesincritos");
		populateDivTable("leilaotop.php","leiloestop");
	</script>
	<script language="javascript" src="js/ajax_forms.js"></script>

</html>
