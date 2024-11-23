<?php
session_start();
include '../CRUD/conexao.php';
// Verifica se o usuário está logado e é um instrutor
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['dados']['tipo_user'] !== "Instrutor") {
    header('Location: ../index.php');
    exit();
}

$idInstrutor = $_SESSION['dados']['id'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Aluno</title>
    <style>
        /* Estilos Gerais */
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
            color: #FF9800;
        }

        a {
            color: #FF9800;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Estilo do Formulário */
        form {
            background-color: #222;
            padding: 20px;
            margin: 30px auto;
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
        }

        label {
            font-size: 16px;
            color: #FF9800;
            display: block;
            margin-bottom: 8px;
        }

        input {
            background-color: #333;
            color: white;
            border: 1px solid #444;
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        input[type="date"] {
            color: white;
        }

        input[type="submit"], button {
            background-color: #FF5722;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #E64A19;
        }

        /* Link de Voltar */
        .voltar {
            text-align: center;
            display: block;
            margin-top: 20px;
            font-size: 16px;
            color: #FF9800;
        }

        .voltar:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Cadastrar Novo Aluno</h1>
    <form action="processa_cadastro_aluno.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        
        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" id="data_nascimento" name="data_nascimento" required>
        
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone">
        
        <input type="submit" value="Cadastrar">
    </form>
    <a href="dashboard_instrutor.php" class="voltar">Voltar</a>
</body>
</html>
