<?php
session_start();
include '../CRUD/conexao.php';

// Verifica se o usuário está logado e é um aluno
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['dados']['tipo_user'] !== "Aluno") {
    header('Location: ../index.php');
    exit();
}

// Obtém o ID do aluno logado
$idAluno = $_SESSION['dados']['id'];

// Consulta para buscar o instrutor atribuído ao aluno
$sqlInstrutor = "
    SELECT i.id, i.nome, i.email, i.telefone 
    FROM cadastro i
    JOIN alunos a ON a.fk_id_instrutor = i.id
    WHERE a.id = ?
";
$stmtInstrutor = $conexao->prepare($sqlInstrutor);
$stmtInstrutor->bind_param("i", $idAluno);
$stmtInstrutor->execute();
$resultInstrutor = $stmtInstrutor->get_result();
$instrutor = $resultInstrutor->fetch_assoc();

// Consulta para buscar os exercícios atribuídos ao aluno
$sqlExercicios = "
    SELECT e.id, e.nome, e.descricao, e.series, e.repeticoes 
    FROM exercicios e
    JOIN aluno_exercicios ae ON ae.exercicio_id = e.id
    WHERE ae.aluno_id = ?
";
$stmtExercicios = $conexao->prepare($sqlExercicios);
$stmtExercicios->bind_param("i", $idAluno);
$stmtExercicios->execute();
$resultExercicios = $stmtExercicios->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Aluno</title>
    <style>
        /* Estilo para o Tema Escuro */
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            margin: 20px;
        }

        h1 {
            color: #FF5722;
        }

        .card {
            border: 1px solid #444;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #1c1c1c;
        }

        .card h3 {
            margin-top: 0;
            color: #FF5722;
        }

        .card p {
            margin: 5px 0;
        }

        .card-exercicio {
            border: 1px solid #007BFF;
            background-color: #2c3e50;
        }

        a {
            text-decoration: none;
            color: #FF5722;
            display: block;
            margin-top: 20px;
        }

        a:hover {
            color: #FF7043;
        }

        .card p strong {
            color: #FF5722;
        }

        footer {
            margin-top: 20px;
            font-size: 14px;
            color: #bbb;
        }
    </style>
</head>
<body>
    <h1>Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['dados']['nome']); ?>!</h1>

    <!-- Card do Instrutor Atribuído -->
    <?php if ($instrutor): ?>
        <div class="card">
            <h3>Seu Instrutor</h3>
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($instrutor['nome']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($instrutor['email']); ?></p>
            <p><strong>Telefone:</strong> <?php echo htmlspecialchars($instrutor['telefone']); ?></p>
        </div>
    <?php else: ?>
        <div class="card">
            <h3>Nenhum instrutor atribuído</h3>
            <p>Entre em contato com a administração para mais informações.</p>
        </div>
    <?php endif; ?>

    <!-- Lista de Exercícios -->
    <div class="card">
        <h3>Seus Exercícios</h3>
        <?php if ($resultExercicios->num_rows > 0): ?>
            <?php while ($exercicio = $resultExercicios->fetch_assoc()): ?>
                <div class="card card-exercicio">
                    <p><strong>Nome:</strong> <?php echo htmlspecialchars($exercicio['nome']); ?></p>
                    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($exercicio['descricao']); ?></p>
                    <p><strong>Séries:</strong> <?php echo htmlspecialchars($exercicio['series']); ?></p>
                    <p><strong>Repetições:</strong> <?php echo htmlspecialchars($exercicio['repeticoes']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Você ainda não tem exercícios atribuídos.</p>
        <?php endif; ?>
    </div>

    <a href="../CRUD/logout.php">Sair</a>
</body>
</html>
