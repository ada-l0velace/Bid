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
		$lid = test_input($_POST["lid"]);
	}
	if(!$lid){
		echo("<div id='erro'> Leilão não existe! </div>");
		exit();
	}
	$pieces = explode(",", $lid);
	$inscreve_query = "INSERT INTO concorrente (pessoa,leilao) 
				       VALUES (:nif,:lid)";
	try {
		// First of all, let's begin a transaction
		$connection->beginTransaction();
		$count = 0;
		foreach ($pieces as $item) {
			$count++;
			// A set of queries; if one fails, an exception should be thrown
			//$inscreve = $connection->prepare($inscreve_query);
			//$inscreve->bindParam(':nif', $nif);
			//$inscreve->bindParam(':lid', $item);
			//$inscreve->execute()
			$connection->query("INSERT INTO concorrente (pessoa,leilao) 
				       VALUES ('$nif','$item')"); // Sql injection plz fix this shit
		}
		// If we arrive here, it means that no exception was thrown
		// i.e. no query has failed, and we can commit the transaction
		$connection->commit();
	} catch (Exception $e) {
		// An exception has been thrown
		$error = $e->getmessage();
		// We must rollback the transaction
		echo("<div id='erro'> Transaction $count failed with error: \n $error!</div>");
		$connection->rollback();
		exit();
	}
	?>
