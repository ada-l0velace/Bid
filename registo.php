<html>
<body>
<?php 
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
// Variáveis de conexão à BD
$host="db.ist.utl.pt"; // o MySQL esta disponivel nesta maquina
$user="ist176563"; // -> substituir pelo nome de utilizador
$password="apjd9878"; // -> substituir pela password dada pelo mysql_reset
$dbname = $user; // a BD tem nome identico ao utilizador
echo("<p>Projeto Base de Dados Parte II</p>\n");
$connection = new PDO("mysql:host=" . $host. ";dbname=" . $dbname, $user, $password, 
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} 
echo("<p>Connected to MySQL database $dbname on $host as user $user</p>\n");
// obtem o pin da tabela pessoa
$sql = "SELECT * FROM pessoa 
		WHERE nif=" . $username; 
$result = $connection->query($sql);
if (!$result) {
 echo("<p> Erro na Query:($sql)<p>");
exit();
}
foreach($result as $row){
$safepin = $row["pin"];
$nif = $row["nif"];
echo($row["nome"]);
$nome = $row["nome"];
}
if ($safepin != $pin ) {
echo "<p>Pin Invalido! Exit!</p>\n";
$connection = null;
 exit;
}
echo "<p>Pin Valido! </p>\n";
// passa variaveis para a sessao;
$_SESSION['username'] = $username; 
$_SESSION['nif'] = $nif;
// Apresenta os leilões
$sql = "SELECT * FROM leilao"; 
$result = $connection->query($sql);
echo("<table border=\"1\">\n");
echo("<tr><td>ID</td><td>nif</td><td>dia</td><td>NrDoDia</td><td>nome</td><td>tipo</td><td>valo
rbase</td></tr>\n");
$idleilao = 0;
foreach($result as $row){
	$idleilao = $idleilao +1; 
	echo("<tr><td>");
	echo($idleilao); echo("</td><td>");
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
$sql = "SELECT leilao.nome, leilao.dia, leilaor.lid 
		FROM concorrente, leilaor, leilao 
		WHERE leilaor.lid = concorrente.leilao 
		AND leilao.nif = leilaor.nif  
		AND concorrente.pessoa = $username 
		AND leilao.dia = leilaor.dia 
		AND leilao.nrleilaonodia = leilaor.nrleilaonodia"; 

$result = $connection->query($sql);
$teste = false;
foreach($result as $row1){
	$teste = true;
}
$result = $connection->query($sql);

if($teste == true){
	echo("<table border=\"1\">\n");
	echo("<tr><td>NrDoDia</td><td>Nome Leilao</td><td>Dia</td></tr>\n");
	$idleilao = 0;
	foreach($result as $row){
		echo("<tr><td>");
		echo($row["lid"]); echo("</td><td>");
		echo($row["nome"]); echo("</td><td>");
		echo($row["dia"]); echo("</td></tr>");
	}
}
?>

<?php 
$sql = "SELECT leilao.nome, leilao.dia, leilaor.lid, MAX(lance.valor) AS max_valor 
		FROM concorrente, leilaor, leilao, lance 
		WHERE lance.leilao = leilaor.lid 
		AND lance.leilao = concorrente.leilao 
		AND leilaor.lid = concorrente.leilao 
		AND leilao.nif = leilaor.nif  
		AND lance.pessoa = $username 
		AND leilao.dia = leilaor.dia 
		AND leilao.nrleilaonodia = leilaor.nrleilaonodia
		GROUP BY leilaor.lid"; 


$result = $connection->query($sql);
$teste = false;
foreach($result as $row1){
	$teste = true;
}
$result = $connection->query($sql);

if($teste == true){
	echo("<table border=\"1\">\n");
	echo("<tr><td>Nr Leilao</td><td>Nome Leilao</td><td>Dia</td><td>Max Valor</td></tr>\n");
	foreach($result as $row){
		echo("<tr><td>");
		echo($row["lid"]); echo("</td><td>");
		echo($row["nome"]); echo("</td><td>");
		echo($row["dia"]); echo("</td><td>");
		echo($row["max_valor"]); echo("</td></tr>");
	}
}
?>

</body>
</html>
