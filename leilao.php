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
	//regista da pessoa no leilão...
	try{
		$inscreve_query = "INSERT INTO concorrente (pessoa,leilao) 
					       VALUES (:nif,:lid)";
		$inscreve = $connection->prepare($inscreve_query);
		$inscreve->bindParam(':nif', $nif);
		$inscreve->bindParam(':lid', $lid);
		$inscreve->execute();
	}
	catch (Exception $e) {
		// An exception has been thrown
		// We must rollback the transaction
		$error = $e->getmessage();
		echo("<div id='erro'> $error </div>");
		exit();
	}
	?>