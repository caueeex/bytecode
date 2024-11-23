<?php
session_start();
include '../CRUD/conexao.php';

// Verifica se o usuário está logado e é um instrutor
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['dados']['tipo_user'] !== "Instrutor") {
    header('Location: ../index.php');
    exit();
}

// Recupera o ID do instrutor logado
$instrutor_id = $_SESSION['dados']['id'];

// Verifica se o instrutor existe na tabela instrutores
$verificar_instrutor = $conexao->prepare("SELECT id FROM instrutores WHERE id = ?");
$verificar_instrutor->bind_param("i", $instrutor_id);
$verificar_instrutor->execute();
$verificar_instrutor->store_result();

// Se o instrutor não for encontrado
if ($verificar_instrutor->num_rows == 0) {
    echo "Erro: Instrutor não encontrado!";
    exit();
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade_exercicios = $_POST['quantidade_exercicios'];
    $aluno_id = $_POST['aluno_id'];  // ID do aluno associado à série
    $data_criacao = date('Y-m-d'); // Data atual

    // Verifica se o aluno existe
    $verificar_aluno = $conexao->prepare("SELECT id FROM alunos WHERE id = ?");
    $verificar_aluno->bind_param("i", $aluno_id);
    $verificar_aluno->execute();
    $verificar_aluno->store_result();

    if ($verificar_aluno->num_rows == 0) {
        echo "Erro: Aluno não encontrado!";
        exit();
    }

    // Consulta SQL para adicionar a série
    $sql = "INSERT INTO series (nome, descricao, quantidade_exercicios, data_criacao, aluno_id) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssisi", $nome, $descricao, $quantidade_exercicios, $data_criacao, $aluno_id);

    // Executa a consulta
    if ($stmt->execute()) {
        header("Location: gerenciar_series.php?msg=sucesso_adicionar");
        exit();
    } else {
        echo "Erro ao adicionar série: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Série</title>
    <!-- Inclua o seu CSS ou Bootstrap aqui -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Adicionar Série</h2>
        <form action="adicionar_serie.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome da Série</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="quantidade_exercicios">Quantidade de Exercícios</label>
                <input type="number" id="quantidade_exercicios" name="quantidade_exercicios" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="aluno_id">Aluno</label>
                <select id="aluno_id" name="aluno_id" class="form-control" required>
                    <?php
                    // Pega os alunos que o instrutor logado criou
                    $stmt = $conexao->prepare("SELECT id, nome FROM alunos WHERE instrutor_id = ?");
                    $stmt->bind_param("i", $instrutor_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($aluno = $result->fetch_assoc()) {
                        echo "<option value='{$aluno['id']}'>{$aluno['nome']}</option>";
                    }
                    ?>
                </select>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Adicionar Série</button>
        </form>
        <br>
        <a href="gerenciar_series.php">Voltar para Gerenciar Séries</a>
    </div>

    <!-- JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
