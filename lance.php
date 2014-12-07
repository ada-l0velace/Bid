<div id='erro'><?php 
	// inicia sessão para passar variaveis entre ficheiros php
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
	// Carregamento das variáveis username e pin do form HTML através do metodo POST;
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	 $lid = test_input($_POST["lid"]);
	 $lance = test_input($_POST["lance"]);
	 } 

	$lance_query="INSERT INTO lance(pessoa,leilao,valor) 
				  VALUES ($nif,$lid,$lance)";
	$result = $connection->prepare($lance_query);
	$error = $result->execute();
		
	if (!$error) {
 		//echo(" Não houve lance:($error) ");
	}
	?></div>