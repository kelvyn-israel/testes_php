<?php
require_once("connect.php"); // sua conexão PDO

// Verifica se o arquivo foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagem_perfil'])) {
    $id = $_POST['id'] ?? null;
    $imagem = $_FILES['imagem_perfil'] ?? null;

    if ($id && $imagem && $imagem['error'] === 0) {
        // Defina o diretório de upload
        $diretorio = "img/"; // Pasta onde as imagens serão armazenadas
        $nome_arquivo = uniqid() . '.' . pathinfo($imagem['name'], PATHINFO_EXTENSION);
        $caminho_arquivo = $diretorio . $nome_arquivo;

        // Move o arquivo para o diretório desejado
        if (move_uploaded_file($imagem['tmp_name'], $caminho_arquivo)) {
            // Atualiza o banco de dados com o novo caminho da imagem
            try {
                $sql = "UPDATE psico SET imagem_perfil = :imagem_perfil WHERE id_psico = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':imagem_perfil', $caminho_arquivo);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    // Retorna a URL da imagem atualizada
                    echo json_encode([
                        'success' => true,
                        'imagem_perfil' => $caminho_arquivo
                    ]);
                } else {
                    echo json_encode(['success' => false]);
                }
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false]);
    }
}
