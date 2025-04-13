<?php
	require_once("connect.php");

	session_start();  // Inicia a sessão

// Recuperando os valores da sessão

	$dados = $_SESSION['dados'] ?? null;

var_dump($_SESSION['dados']);




