<html>
<body>
<?php 
// inicia sessão para passar variaveis entre ficheiros php
session_start();
$username = $_SESSION['username']; 
$nif = $_SESSION['nif']; 
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
// Conexão à BD
$host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
$user="ist176563"; // -> substituir pelo nome de utilizador
$password="apjd9878"; // -> substituir pela password dada pelo mysql_reset
$dbname = $user; // a BD tem nome identico ao utilizador
$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password, 
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
echo("<p>Connected to MySQL database $dbname on $host as user $user</p>\n");
//regista a pessoa no leilão. Exemplificativo apenas.....
echo($lid);
echo("<p>");
echo($lance);
echo("<p>");

$ultimolance_query="SELECT MAX(lance.valor) AS max_valor 
                    FROM lance 
                    WHERE lance.leilao = $lid";
$ultimolance = $connection->query($ultimolance_query);
$teste = false;
foreach($ultimolance as $row){
	if($row['max_valor'] == ""){
		$teste = true;
		echo("<p>");
		echo("testes");
		echo("<p>");
	}

}
$ultimolance = $connection->query($ultimolance_query);

if($teste == true){

// empty, isnull e nada funciona
/*if($ultimolance->num_rows <= 0){*/
	$valorbase_query="SELECT valorbase AS min_valor 
					  FROM leilaor, leilao 
					  WHERE leilaor.lid = $lid 
					  AND leilaor.dia = leilao.dia 
					  AND leilaor.nrleilaonodia = leilao.nrleilaonodia 
					  AND leilaor.nif = leilao.nif";
	$valorbase = $connection->query($valorbase_query);

	foreach($valorbase as $row){
		$valor_min = $row["min_valor"];
	}



	$valor_max = 0;
}else{
	foreach($ultimolance as $row1){
		$valor_max = $row1["max_valor"];
	}
	$valor_min = 0;
	// echo("<p>");
	// echo("oi");
	// echo("</p>");
}
// echo("<p>");
// echo($valorbase_query);
// echo("<p>");
 
/*echo("<p>");
echo($valor_min);
echo("<p>");

echo("<p>");
echo($valor_max);
echo("<p>");*/

if($valor_max < $lance and $valor_min <= $lance){
	$lance_query="INSERT INTO lance(pessoa,leilao,valor) 
				  VALUES ($nif,$lid,$lance)";
	$result = $connection->query($lance_query);
	
	echo($lance_query);
	
	if (!$result) {
 		echo("<p> Não houve lance:($sql) </p>");
	}
}else{
	echo("<p> O valor do lance é inválido </p>");
}



// to be continued….
//termina a sessão
session_destroy();
?>
</body>
</html>