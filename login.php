<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
</head>
<body>

	<h2 align="center">Faça login</h2>

	<form action="loggin.php" method="POST">
		<label for="login">Informe seu CRP</label><br>
		<input type="number" name="crp" required><br>

		<br><label for="pass">Informe sua senha</label><br>
		<input type="password" name="senha" required><br>

		<input type="submit" name="" value="Enviar">
	</form>

</body>
</html>