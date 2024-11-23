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
    <title>Gerar Relatórios - Instrutor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            background-color: #FF5722;
            color: white;
            padding: 20px;
            width: 100%;
            text-align: center;
        }

        main {
            max-width: 800px;
            width: 100%;
            margin: 20px auto;
            background: #1c1c1c;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            margin-top: 0;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #FF9800;
        }

        select, input {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            background-color: #333;
            border: 1px solid #555;
            color: white;
            border-radius: 5px;
        }

        button {
            background-color: #FF5722;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #E64A19;
        }

        footer {
            margin-top: 20px;
            font-size: 14px;
            color: #bbb;
        }

        footer a {
            color: red;
            background: none;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Gerar Relatórios</h1>
        <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['dados']['nome']); ?>!</p>
    </header>
    <main>
        <h2>Escolha o Tipo de Relatório</h2>
        <form action="gerar_relatorio.php" method="GET">
            <label for="tipo_relatorio">Tipo de Relatório</label>
            <select name="tipo_relatorio" id="tipo_relatorio" required>
                <option value="">Selecione um tipo</option>
                <option value="alunos">Relatório de Alunos</option>
                <option value="equipamentos">Relatório de Equipamentos</option>
                <option value="series">Relatório de Séries e Exercícios</option>
                <option value="relatorio_geral">Relatório Geral</option>
            </select>

            <label for="data_inicio">Data de Início</label>
            <input type="date" id="data_inicio" name="data_inicio">

            <label for="data_fim">Data de Fim</label>
            <input type="date" id="data_fim" name="data_fim">

            <button type="submit">Gerar Relatório</button>
        </form>
    </main>
    <footer>
        <a href="../CRUD/logout.php">Sair</a>
    </footer>
</body>
</html>
