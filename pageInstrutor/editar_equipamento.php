<?php
session_start();
include '../CRUD/conexao.php';

// Verifica se o usuário está logado e é um instrutor
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['dados']['tipo_user'] !== "Instrutor") {
    header('Location: ../index.php');
    exit();
}

// Verifica se o ID do equipamento foi passado via URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $instrutor_id = $_SESSION['dados']['id']; // ID do instrutor logado

    // Consulta para pegar os dados do equipamento com base no ID e no instrutor logado
    $sql = "SELECT * FROM equipamentos WHERE id = ? AND instrutor_id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ii", $id, $instrutor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se o equipamento não for encontrado ou não pertencer ao instrutor logado, redireciona
    if ($result->num_rows == 0) {
        header("Location: gerenciar_equipamentos.php?msg=erro_equipamento_nao_encontrado");
        exit();
    }

    // Pega os dados do equipamento
    $equipamento = $result->fetch_assoc();
} else {
    header("Location: gerenciar_equipamentos.php?msg=erro_id_invalido");
    exit();
}

// Verifica se o formulário foi submetido para atualizar o equipamento
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['acao']) && $_POST['acao'] == 'editar') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $data_aquisicao = $_POST['data_aquisicao'];
    $status = $_POST['status'];

    // Atualiza os dados no banco de dados
    $sql_update = "UPDATE equipamentos SET nome = ?, descricao = ?, quantidade = ?, data_aquisicao = ?, status = ? WHERE id = ? AND instrutor_id = ?";
    $stmt_update = $conexao->prepare($sql_update);
    $stmt_update->bind_param("ssissii", $nome, $descricao, $quantidade, $data_aquisicao, $status, $id, $instrutor_id);

    if ($stmt_update->execute()) {
        header("Location: gerenciar_equipamentos.php?msg=sucesso_editar");
        exit();
    } else {
        header("Location: gerenciar_equipamentos.php?msg=erro_editar");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Equipamento</title>
    <style>
        /* Estilo Geral */
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
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

        /* Formulário de Edição */
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
    <h1>Editar Equipamento</h1>

    <form action="editar_equipamento.php?id=<?php echo $equipamento['id']; ?>" method="POST">
        <input type="hidden" name="acao" value="editar">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $equipamento['nome']; ?>" required><br><br>

        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" value="<?php echo $equipamento['descricao']; ?>" required><br><br>

        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" value="<?php echo $equipamento['quantidade']; ?>" required><br><br>

        <label for="data_aquisicao">Data de Aquisição:</label>
        <input type="date" id="data_aquisicao" name="data_aquisicao" value="<?php echo $equipamento['data_aquisicao']; ?>" required><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="Ativo" <?php echo $equipamento['status'] == 'Ativo' ? 'selected' : ''; ?>>Ativo</option>
            <option value="Inativo" <?php echo $equipamento['status'] == 'Inativo' ? 'selected' : ''; ?>>Inativo</option>
        </select><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <a href="gerenciar_equipamentos.php" class="voltar">Voltar para a lista de equipamentos</a>
</body>
</html>
