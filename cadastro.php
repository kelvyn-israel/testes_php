<?php

require_once("connect.php");

$nome = $_POST['nome'] ?? null;
$senha = $_POST['pass'] ?? null;
$idade = $_POST['idade'] ?? null;
$preco = $_POST['preco'] ?? null;
$email = $_POST['email'] ?? null;
$crp = $_POST['crp'] ?? null;
$genero = $_POST['genero'] ?? null;
$telefone = $_POST['telefone'] ?? null;
$especialidades = $_POST['especialidades'] ?? null;
$abord = $_POST['abordagens'] ?? null;
$pass = password_hash($senha, PASSWORD_DEFAULT);
$imagem = $_FILES['imagem'];

$imagemPath = null;

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $nomeTemp = $_FILES['imagem']['tmp_name'];
    $nomeOriginal = basename($_FILES['imagem']['name']);
    $ext = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    $infoImg = getimagesize($nomeTemp);
    if ($infoImg && in_array($ext, $permitidas)) {
        $novoNome = uniqid('img_', true) . '.' . $ext;
        $pastaDestino = 'C:\xampp\htdocs\testes\img' . DIRECTORY_SEPARATOR;



        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0755, true);
        }

        $imagemPath = $pastaDestino . $novoNome;
        move_uploaded_file($nomeTemp, $imagemPath);
    }
}



$campos = [$nome, $senha, $idade, $preco, $email, $crp, $genero, $telefone, $especialidades, $abord];
$camposValidos = true;

foreach ($campos as $campo) {
    if (!isset($campo) && trim($campo) === '') {
        $camposValidos = false;
        break;
    }
}

if ($camposValidos) {
    try {
        $pdo->beginTransaction();

        $stmt_psico = $pdo->prepare("INSERT INTO psico (nome, pass, age, email, preco_consulta, crp, genero, imagem_perfil) VALUES (:nome, :pass, :age, :email, :preco_consulta, :crp, :genero, :imagem_perfil)");
        $stmt_psico->execute([
            ':nome' => $nome,
            ':pass' => $pass,
            ':age' => $idade,
            ':email' => $email,
            ':preco_consulta' => $preco,
            ':crp' => $crp,
            ':genero' => $genero,
            ':imagem_perfil' =>$imagemPath
        ]);

        $lastId = $pdo->lastInsertId();

        $stmt_contato = $pdo->prepare("INSERT INTO contato (contato, id_psico_fk) VALUES (:telefone, :lastId)");
        $stmt_contato->execute([
            ':telefone' => $telefone,
            ':lastId' => $lastId
        ]);

        foreach ($especialidades as $especialidade) {
            $stmt_especialidade = $pdo->prepare("INSERT INTO espec (espec, id_psico_fk) VALUES (:espec, :lastId)");
            $stmt_especialidade->execute([
                ':espec' => $especialidade,
                ':lastId' => $lastId
            ]);
        }

        foreach ($abord as $abordagem) {
            $stmt_abordagem = $pdo->prepare("INSERT INTO abordagem (abordagem, id_psico_fk) VALUES (:abordagem, :lastId)");
            $stmt_abordagem->execute([
                ':abordagem' => $abordagem,
                ':lastId' => $lastId
            ]);
        }

        $pdo->commit();

        echo "<script>
            alert('Cadastro realizado com sucesso!');
            window.location.href = 'index.php';
        </script>";

    } catch (Exception $e) {
        $pdo->rollBack();
        $erro = "[" . date('Y-m-d H:i:s') . "] Erro: " . $e->getMessage() . "\n";
        file_put_contents('logs/erros.log', $erro, FILE_APPEND);

    }

} else {
    echo "<script>
        alert('Falha ao realizar o cadastro! Verifique os campos preenchidos e tente novamente!');
        window.location.href = 'index.php';
    </script>";
}

?>
