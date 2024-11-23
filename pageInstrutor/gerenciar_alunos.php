<?php
session_start();
include '../CRUD/conexao.php';

// Verifica se o usuário está logado e é um instrutor
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['dados']['tipo_user'] !== "Instrutor") {
    header('Location: ../index.php');
    exit();
}

$idInstrutor = $_SESSION['dados']['id'];

// Busca alunos associados ao instrutor
$sql = "SELECT * FROM alunos WHERE fk_id_instrutor= ?";
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
    <title>Gerenciar Alunos</title>
    <style>
        /* Estilo Geral */
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

        header h1 {
            margin: 0;
        }

        main {
            max-width: 1000px;
            width: 100%;
            margin: 20px auto;
            background: #1c1c1c;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #444;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
        }

        tr:nth-child(even) {
            background-color: #2c2c2c;
        }

        tr:hover {
            background-color: #444;
        }

        a {
            color: #FF5722;
            text-decoration: none;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        footer {
            margin-top: 20px;
            font-size: 14px;
            color: #bbb;
        }
    </style>
</head>
<body>
    <header>
        <h1>Gerenciar Alunos</h1>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data de Nascimento</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($aluno = $resultado->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $aluno['id']; ?></td>
                        <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                        <td><?php echo htmlspecialchars($aluno['email']); ?></td>
                        <td><?php echo $aluno['data_nasc']; ?></td>
                        <td><?php echo $aluno['telefone']; ?></td>
                        <td>
                            <a href="editar_aluno.php?id=<?php echo $aluno['id']; ?>">Editar</a>
                            <a href="excluir_aluno.php?id=<?php echo $aluno['id']; ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="dashboard_instrutor.php">Voltar</a>
    </main>
    <footer>
        <p>&copy; 2024 Instrutores Fitness</p>
    </footer>
</body>
</html>
