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
	<input type="button" value="registo normal" onclick="location.href = 'registo.php'" />
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
		$query_days = "SELECT DISTINCT dia 
						FROM leilao 
						ORDER BY dia";
		$days = $connection->prepare($query_days);
		$days->execute();
		echo('<form id="table_filter_leilao" method="post">');
			echo ('<br> Choose the day you want: <select id="dropdown_days" name="dropdown_days">');
			echo '<option value="'."0".'">'."---------".'</option>';
			foreach($days as $row)
				echo '<option value="'.$row['dia'].'">'.$row['dia'].'</option>';
			echo ('</select>');// Close your drop down box
		echo('</form>');
	?>
	<div id="table_filterDay_leilao"></div>
	<form id="leilao_transaction" method="post">
		<h2>Escolha os IDs dos leiloes que pretende concorrer separados por virgulas exemplo(1,2,3,4)</h2>
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
		$(window).load(function () {
			populateDivTable("leilaoinscritos.php","leiloesincritos");
			populateDivTable("leilaotop.php","leiloestop");
			$("#dropdown_days").val($("#dropdown_days option:eq(1)").val());
    		$("#table_filter_leilao").submit();
		});
	</script>
	<script language="javascript" src="js/ajax_forms.js"></script>
</html>
