<?php

	require_once("connect.php");

	$crp = $_POST['crp'];
	$senha = $_POST['senha'];

	$campos = [$crp, $senha];
	$camposValidos = true;

	foreach ($campos as $campo) {
    	if (!isset($campo) && trim($campo) === '') {
        	$camposValidos = false;
        	break;
    }
}

//Trecho acima recebe os dados do formulário e valida se estão corretos. Caso estejam corretos, executa o trecho abaixo

	if($camposValidos) {
		try{
			$pdo->beginTransaction();

		$sql = "SELECT pass, id_psico FROM psico WHERE crp = :crp";
			
			$stmt_psico = $pdo->prepare($sql);
			$stmt_psico->execute(['crp' => $crp]);

			$password = $stmt_psico->fetch(PDO::FETCH_ASSOC);
			$id = $password['id_psico'];
			$pass = $password['pass'];


//O Trecho acima realiza a busca da senha e CRP na tabela principal utilizando o "CRP" do psicólogo, fornecido pelo usuário.

			if (password_verify($senha, $password['pass'])) {
				$sql_completion = "SELECT 
    							p.*,
    							GROUP_CONCAT(DISTINCT a.abordagem) AS abordagens,
    							GROUP_CONCAT(DISTINCT c.contato) AS contatos,
    							GROUP_CONCAT(DISTINCT e.espec) AS especializacoes
								FROM psico p
								INNER JOIN abordagem a ON p.id_psico = a.id_psico_fk
								INNER JOIN contato c ON p.id_psico = c.id_psico_fk
								INNER JOIN espec e ON p.id_psico = e.id_psico_fk
								WHERE p.id_psico = :id
								GROUP BY p.id_psico";

				/*Abaixo, crio a "$_SESSION para levar os dados à página principal do usuário*/

				$stmt_completion = $pdo->prepare($sql_completion);
				$stmt_completion->execute(['id' => $id]);
				$dados = $stmt_completion->fetch(PDO::FETCH_ASSOC);

				session_start();

				$_SESSION['key'] = $id;
				$_SESSION['dados'] = $dados;
				echo "<script>
        			window.location.href = 'pagina_principal.php';
   				 	</script>";


//Este código verifica se a senha digitada corresponde a senha presente no banco de dados. Caso esteja correta, realiza outro select utilizando "inner join", garantindo que as tabelas estejam preenchidas. Caso a senha esteja incorreta, deverá informar ao usuário e redirecioná-lo a tela de login.

		} else {
			echo "<script>
        			alert('Senha incorreta!');
        			window.location.href = 'login.php';
   				 </script>";
		}

	} catch (PDOException $e) {
		
	}
}

?>