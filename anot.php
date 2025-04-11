<?php
// Conexão com o banco (MySQL usando PDO)
$host = 'localhost';
$db   = 'test';        // Nome do banco de dados
$user = 'root';        // Usuário do banco
$pass = '';            // Senha do banco

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($_POST['opcoes'])) {
        $opcoesSelecionadas = $_POST['opcoes'];

        // Preparar a query de insert
        $stmt = $pdo->prepare("INSERT INTO test (dados) VALUES (:dados)");

        // Percorrer o array e inserir cada item
        foreach ($opcoesSelecionadas as $opcao) {
            $stmt->execute([':dados' => $opcao]);
        }

        echo "Inserções realizadas com sucesso!";
    } else {
        echo "Nenhuma opção foi selecionada.";
    }

} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}




$stmt = $pdo->prepare("INSERT INTO usuarios (nome) VALUES (:nome)");
$stmt->execute([':nome' => 'João']);

// Pega o último ID inserido
$ultimoId = $pdo->lastInsertId();


$pdo->lastInsertId();


<?php
// Conexão com o banco (MySQL usando PDO)
$host = 'localhost';
$db   = 'test';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Suponha que você tenha inserido algo antes, e quer usar o ID:
    $stmtUsuario = $pdo->prepare("INSERT INTO usuarios (nome) VALUES (:nome)");
    $stmtUsuario->execute([':nome' => 'João']);

    $usuarioId = $pdo->lastInsertId(); // Pegando o último ID inserido

    if (!empty($_POST['opcoes'])) {
        $opcoesSelecionadas = $_POST['opcoes'];

        // Suponha que sua tabela 'test' tem os campos: id, dados, usuario_id
        $stmt = $pdo->prepare("INSERT INTO test (dados, usuario_id) VALUES (:dados, :usuario_id)");

        foreach ($opcoesSelecionadas as $opcao) {
            $stmt->execute([
                ':dados' => $opcao,
                ':usuario_id' => $usuarioId
            ]);
        }

        echo "Inserções realizadas com sucesso!";
    } else {
        echo "Nenhuma opção foi selecionada.";
    }

} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}








try {
    $pdo = new PDO("mysql:host=localhost;dbname=teste;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Simula dados do usuário
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $dadosExtras = $_POST['extras'] ?? []; // array associativo chave => valor

    $pdo->beginTransaction();

    // 1. Inserir usuário
    $stmtUser = $pdo->prepare("INSERT INTO usuarios (nome, email) VALUES (:nome, :email)");
    $stmtUser->execute([
        ':nome' => $nome,
        ':email' => $email
    ]);
    $usuarioId = $pdo->lastInsertId();

    // 2. Inserir cada item do array extras como uma linha separada
    $stmtExtra = $pdo->prepare("INSERT INTO dados_extra (usuario_id, campo, valor) VALUES (:usuario_id, :campo, :valor)");

    foreach ($dadosExtras as $chave => $valor) {
        if (trim($valor) !== '') {
            $stmtExtra->execute([
                ':usuario_id' => $usuarioId,
                ':campo' => $chave,
                ':valor' => $valor
            ]);
        }
    }

    $pdo->commit();
    echo "Usuário e dados extras inseridos com sucesso!";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Erro: " . $e->getMessage();
}




