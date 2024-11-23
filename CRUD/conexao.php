<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "banco_academia";

// Conexão com o banco de dados 
$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verificar se a conexão com o banco não deu erro
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}
