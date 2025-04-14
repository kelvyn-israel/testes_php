<?php
require_once("connect.php");
session_start();

$dados = $_SESSION['dados'] ?? null;

if ($dados) {
    $id_psico = $dados['id_psico'];
    $nome = $dados['nome'];
    $pass = $dados['pass'];
    $age = $dados['age'];
    $email = $dados['email'];
    $preco_consulta = $dados['preco_consulta'];
    $crp = $dados['crp'];
    $genero = $dados['genero'];
    $imagem_perfil = $dados['imagem_perfil'];
    $descricao = $dados['descricao'];
    $abordagens = $dados['abordagens'];
    $contatos = $dados['contatos'];
    $especializacoes = $dados['especializacoes'];

    $lista_abordagens = explode(',', $abordagens);
    $lista_especializacoes = explode(',', $especializacoes);
    $img_perfil = str_replace("C:\\xampp\\htdocs", "", $imagem_perfil);
    $img_perfil = str_replace('\\', '/', $img_perfil);
} else {
    session_destroy();
    echo "<script>alert('Faça login para continuar!');
     		window.location.href = 'login.php';
   		</script>";
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Página Principal</title>
	<script type="text/javascript" src="function.js"></script>
</head>
<body>

	<table border="1" cellpadding="8">
    <tr>
        <th>Imagem de Perfil</th>
        <td>
            <img id="img_perfil" src="<?= htmlspecialchars($img_perfil) ?>" alt="Imagem de perfil" width="150"><br>
            <a href="#" onclick="document.getElementById('input_imagem').click();">Alterar Foto</a>
            <input type="file" id="input_imagem" style="display: none;" onchange="atualizarImagem(event, <?= $id_psico ?>)">
        </td>
    </tr>
    <tr>
        <th>Nome</th>
        <td><?= htmlspecialchars($nome) ?></td> <!-- Não editável -->
    </tr>
    <tr>
        <th>Idade</th>
        <td contenteditable="true" 
            onblur="atualizarCampo(this, 'age', <?= $id_psico ?>)">
            <?= htmlspecialchars($age) ?>
        </td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?= htmlspecialchars($email) ?></td> <!-- Não editável -->
    </tr>
    <tr>
        <th>Preço da Consulta</th>
        <td contenteditable="true" 
            onblur="atualizarCampo(this, 'preco_consulta', <?= $id_psico ?>)">
            <?= number_format($preco_consulta, 2, ',', '.') ?>
        </td>
    </tr>
    <tr>
        <th>CRP</th>
        <td><?= htmlspecialchars($crp) ?></td> <!-- Não editável -->
    </tr>
    <tr>
        <th>Gênero</th>
        <td><?= htmlspecialchars($genero) ?></td> <!-- Não editável -->
    </tr>
    <tr>
        <th>Descrição</th>
        <td contenteditable="true" 
            onblur="atualizarCampo(this, 'descricao', <?= $id_psico ?>)">
            <?= htmlspecialchars($descricao) ?>
        </td>
    </tr>
    <tr>
        <th>Abordagens</th>
        <td contenteditable="true" 
            onblur="atualizarCampo(this, 'abordagens', <?= $id_psico ?>)">
            <?= htmlspecialchars($abordagens) ?>
        </td>
    </tr>
    <tr>
        <th>Especializações</th>
        <td contenteditable="true" 
            onblur="atualizarCampo(this, 'especializacoes', <?= $id_psico ?>)">
            <?= htmlspecialchars($especializacoes) ?>
        </td>
    </tr>
    <tr>
        <th>Contatos</th>
        <td contenteditable="true" 
            onblur="atualizarCampo(this, 'contatos', <?= $id_psico ?>)">
            <?= htmlspecialchars($contatos) ?>
        </td>
    </tr>

    <tr>
    <th>Senha</th>
    <td>
        <button onclick="mostrarCampoSenha()">Alterar Senha</button>
        <div id="senhaContainer" style="display:none; margin-top: 10px;">
            <input type="password" id="senhaAtual" placeholder="Senha atual"><br><br>
            <input type="password" id="novaSenha" placeholder="Nova senha"><br><br>
            <button onclick="alterarSenha(<?= $id_psico ?>)">Salvar</button>
        </div>
    </td>
</tr>

    <tr>
        <td colspan="2" style="text-align: center;">
            <div id="mensagem" style="margin-top: 10px;"></div> <!-- Mensagem de Sucesso/Error -->
        </td>
    </tr>

</table>

<form action="logout.php" method="post" style="margin-bottom: 20px;">
    <button type="submit">Logoff</button>
</form>

</body>
</html>
