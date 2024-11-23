<?php
session_start();
include '../CRUD/conexao.php';

// Verifica se o usuário está logado e é um administrador
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['dados']['tipo_user'] !== "Administrador") {
    header('Location: ../index.php');
    exit();
}

// Consulta para pegar todos os usuários (alunos e instrutores)
$sql = "SELECT id, nome, email, tipo_user FROM cadastro";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$resultado = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Administrador</title>
    <style>
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
            color: white;
        }
        tr:nth-child(even) {
            background-color: #2c2c2c;
        }
        tr:hover {
            background-color: #444;
        }
        a {
            text-decoration: none;
            color: #FF5722;
        }
        a:hover {
            color: #FF7043;
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

    <!-- Card de Usuários -->
    <div class="card">
        <h3>Usuários da Plataforma</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Tipo de Usuário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['tipo_user']); ?></td>
                        <td>
                            <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>">Editar</a> |
                            <a href="excluir_usuario.php?id=<?php echo $usuario['id']; ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <a href="../CRUD/logout.php">Sair</a>
    </footer>
</body>
</html>
