<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Formulário com Choices.js</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    form {
      max-width: 500px;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    input, select, textarea {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      box-sizing: border-box;
    }

    button {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

  <h2>Formulário com múltiplas seleções</h2>

  <form action="teste.php" method="POST">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="senha">Senha:</label>
    <input type="password" id="pass" name="pass" required>

    <label for="idade">Idade:</label>
    <input type="number" id="idade" name="idade" required>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required>

    <label for="preco">Preço (R$):</label>
    <input type="number" step="0.01" id="preco" name="preco" required>

    <label for="crp">CRP:</label>
    <input type="text" id="crp" name="crp" required>

    <label for="genero">Gênero:</label>
    <select id="genero" name="genero" required>
      <option value="">Selecione</option>
      <option value="masculino">Masculino</option>
      <option value="feminino">Feminino</option>
      <option value="nao-binario">Não-binário</option>
      <option value="outro">Outro</option>
      <option value="prefiro-nao-dizer">Prefiro não dizer</option>
    </select>

    <label for="telefone">Telefone:</label>
    <input type="tel" id="telefone" name="telefone" required>

    <label for="especialidades">Especialidades:</label>
    <select id="especialidades" name="especialidades[]" multiple>
      <option value="ansiedade">Ansiedade</option>
      <option value="depressao">Depressão</option>
      <option value="transtornos-alimentares">Transtornos Alimentares</option>
      <option value="tdah">TDAH</option>
    </select>

    <label for="abordagens">Abordagens:</label>
    <select id="abordagens" name="abordagens[]" multiple>
      <option value="cognitivo-comportamental">Cognitivo-Comportamental</option>
      <option value="psicanalise">Psicanálise</option>
      <option value="humanista">Humanista</option>
      <option value="sistemica">Sistêmica</option>
    </select>

    <button type="submit">Enviar</button>
  </form>

  <!-- Choices.js -->
  <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
  <script>
    new Choices('#especialidades', {
      removeItemButton: true,
      placeholder: true,
      placeholderValue: 'Selecione uma ou mais especialidades'
    });

    new Choices('#abordagens', {
      removeItemButton: true,
      placeholder: true,
      placeholderValue: 'Selecione uma ou mais abordagens'
    });
  </script>
</body>
</html>
