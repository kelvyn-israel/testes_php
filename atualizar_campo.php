<?php
require_once("connect.php"); // sua conexão PDO

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $campo = $_POST['campo'] ?? null;
    $valor = $_POST['valor'] ?? null;

    // Lista de campos permitidos para evitar SQL injection
    $campos_permitidos = [
        'age',
        'preco_consulta',
        'imagem_perfil',
        'descricao',
        'abordagens',
        'contatos',
        'especializacoes'
    ];

    if ($id && in_array($campo, $campos_permitidos)) {
        try {
            // Prepara a query dinamicamente
            $sql = "UPDATE psico SET {$campo} = :valor WHERE id_psico = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':valor', $valor);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "Campo '$campo' atualizado com sucesso.";
            } else {
                echo "Erro ao atualizar o campo.";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        echo "Campo inválido ou dados incompletos.";
    }
} else {
    echo "Requisição inválida.";
}
