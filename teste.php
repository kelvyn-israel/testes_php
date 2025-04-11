<?php

require_once("connect.php"); //Realiza a inclusão do arquivo de conexão ao banco de dados

$nome = $_POST['nome'] ?? null;
$senha = $_POST['pass'] ?? null;
$idade = $_POST['idade'] ?? null;
$preco = $_POST['preco'] ?? null;
$email = $_POST['email'] ?? null;
$crp = $_POST['crp'] ?? null;
$genero = $_POST['genero'] ?? null;
$telefone = $_POST['telefone'] ?? null;
$especialidades = $_POST['especialidades'] ?? null;
$abordagens = $_POST['abordagens'] ?? null;
$pass = sha1($senha);

//Código acima recebe os dados vindos do formulário no formato array, e atribui cada posição do array (chave) a uma váriável de mesmo valor
//print($pass);

$campos = [$nome, $senha, $idade, $preco, $email, $crp, $genero, $telefone, $especialidades, $abordagens];
$camposValidos = true;
//Cria um array com todos os campos obrigatórios e cria uma variável de controle


foreach ($campos as $campo) {
	if (!isset($campo) && trim($campo) === '') {
		$camposValidos = false;
		break;
	}
}
//Percorre o array criado e verifica se todas as posições estão preenchidas corretamente

if ($camposValidos) {
	$pdo->beginTransaction();
	
	$stmt_psico = $pdo->prepare("INSERT INTO psico (nome, pass, age, email, preco_consulta, crp, genero) VALUES (:nome, :pass, :age, :email, :preco_consulta, :crp, :genero)");
	$stmt_psico->execute([
		':nome'=> $nome,
		':pass'=> $pass,
		':age'=> $idade,
		':email' => $email,
		':preco_consulta'=> $preco,
		':crp'=> $crp,
		':genero'=>$genero]);

		$lastId = $pdo->lastInsertId();

	$stmt_contato = $pdo->prepare("INSERT INTO contato (contato, id_contato_fk)")


		
} else {
	echo "Um ou mais campos estão vazios ou inválidos.";
}
//Realiza a inserção no banco de dados. Caso seja apresentado algum erro nos campos, a inserção é interrompida, não sendo alterado nenhum dado no banco
//var_dump($campos);


?>
