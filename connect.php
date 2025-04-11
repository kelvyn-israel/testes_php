<?php
// Conexão com o banco (MySQL usando PDO)
$host = 'localhost';
$db   = 'testes';        // Nome do banco de dados
$user = 'root';        // Usuário do banco
$pass = '';            // Senha do banco


    try{$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e){
        echo "Erro na conexão: " . $e->getMessage();
    }

    //Trecho acima estabelece uma conexão com o banco de dados
?>
