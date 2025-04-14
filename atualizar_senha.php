<?php
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? null;
    $senhaAtual = $_POST['senhaAtual'] ?? '';
    $novaSenha = $_POST['novaSenha'] ?? '';

    if (!$id || !$senhaAtual || !$novaSenha) {
        echo "Preencha todos os campos.";
        exit;
    }

    // Verifica senha atual
    $stmt = $pdo->prepare("SELECT pass FROM psico WHERE id_psico = ?");
    $stmt->execute([$id]);
    $senhaHashBanco = $stmt->fetchColumn();

    if (!$senhaHashBanco || !password_verify($senhaAtual, $senhaHashBanco)) {
        echo "Senha atual incorreta.";
        exit;
    }

    // Atualiza com nova senha
    $novaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE psico SET pass = ? WHERE id_psico = ?");
    if ($stmt->execute([$novaHash, $id])) {
        echo "Senha atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar a senha.";
    }
}
