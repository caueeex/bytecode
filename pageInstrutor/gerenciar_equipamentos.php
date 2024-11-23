<?php
session_start();
include '..//CRUD/conexao.php';

// Verifica se o usuário está logado e é um instrutor
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['dados']['tipo_user'] !== "Instrutor") {
    header('Location: ../index.php');
    exit();
}

// Obtém o ID do instrutor logado
$idInstrutor = $_SESSION['dados']['id'];

// Busca equipamentos cadastrados pelo instrutor
$sql = "SELECT * FROM equipamentos WHERE instrutor_id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $idInstrutor);
$stmt->execute();
$resultado = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Equipamentos</title>
    <style>
        /* Estilo Geral */
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            color: #FF9800;
            text-align: center;
        }

        a {
            color: #FF9800;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Formulário de Adição */
        form {
            background-color: #222;
            padding: 20px;
            margin: 30px auto;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
        }

        label {
            display: block;
            color: #FF9800;
            margin-bottom: 10px;
            font-size: 16px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #444;
            background-color: #333;
            color: white;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #FF5722;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #E64A19;
        }

        /* Tabela de Equipamentos */
        table {
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #444;
        }

        th {
            background-color: #333;
            color: #FF9800;
        }

        td {
            background-color: #222;
        }

        /* Botões de Ação */
        .acoes a {
            color: #FF5722;
            margin-right: 10px;
        }

        .acoes a:hover {
            color: #E64A19;
        }

        /* Link Voltar */
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
    <h1>Gerenciar Equipamentos</h1>

    <!-- Formulário para cadastrar novo equipamento -->
    <form action="./processo_equipamento.php" method="POST">
        <input type="hidden" name="acao" value="adicionar">
        <label>Nome: <input type="text" name="nome" required></label>
        <label>Descrição: <textarea name="descricao"></textarea></label>
        <label>Quantidade: <input type="number" name="quantidade" required></label>
        <label>Data de Aquisição: <input type="date" name="data_aquisicao"></label>
        <label>Status: 
            <select name="status">
                <option value="Disponível">Disponível</option>
                <option value="Em Manutenção">Em Manutenção</option>
                <option value="Indisponível">Indisponível</option>
            </select>
        </label>
        <button type="submit">Adicionar Equipamento</button>
    </form>

    <!-- Tabela de equipamentos cadastrados -->
    <h2>Equipamentos Cadastrados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($equipamento = $resultado->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $equipamento['id']; ?></td>
                    <td><?php echo htmlspecialchars($equipamento['nome']); ?></td>
                    <td><?php echo htmlspecialchars($equipamento['descricao']); ?></td>
                    <td class="acoes">
                        <a href="editar_equipamento.php?id=<?php echo $equipamento['id']; ?>">Editar</a> | 
                        <a href="excluir_equipamento.php?id=<?php echo $equipamento['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este equipamento?');">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard_instrutor.php" class="voltar">Voltar</a>
</body>
</html>
