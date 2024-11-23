<?php
session_start(); // Inicia a sessão

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Captura os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha_cripto = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Consulta SQL para inserir os dados no banco (sem tipo_user, pois é gerenciado pelo banco)
    $sql = "INSERT INTO cadastro (nome, email, telefone, senha) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conexao->error);
    }

    $stmt->bind_param("ssss", $nome, $email, $telefone, $senha_cripto);

    // Executa a consulta e verifica o resultado
    if ($stmt->execute()) {
        header('Location: ../index.php'); // Redireciona após cadastro
        exit();
    } else {
        echo "Erro ao executar a consulta SQL: " . $stmt->error;
    }

    $stmt->close();
}

$conexao->close();
?>
