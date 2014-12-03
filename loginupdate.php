<?php 
	include 'includes/dbconnection.php';
	session_start();
	// Função para limpar os dados de entrada
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
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
	$empty = false;
	foreach($pessoa as $row){
		if($row["nome"] != ""){
			echo "asd";
			$empty = true;
			$safepin = $row["pin"];
			$nif = $row["nif"];
			$_SESSION['pessoa']= $row["nome"];
			$nome = $row["nome"];
		}
	}
	if($empty == false){
		header("Location: logout.php");
		exit();
	}
	if ($safepin != $pin ) {
		echo "<p>Pin Invalido! Exit!</p>\n";
		$connection = null;
		$error = "Nif or Pin invalid!";
		//alert('error');
		header("Location: logout.php"."?"."login_erro=". $error);
		exit();
	}
	echo "<p>Pin Valido! </p>\n";
	// passa variaveis para a sessao;
	$_SESSION['username'] = $username; 
	$_SESSION['nif'] = $nif;
	header("Location: registo.php");

?>