<?php
	session_start();
	// Função para limpar os dados de entrada
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	test_input($_SESSION["username"]);
	test_input($_SESSION["nif"]);
	test_input($_SESSION['pessoa']);
	session_destroy();
	header("Location: login.php");
?>