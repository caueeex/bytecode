<?php
session_start();
include '../CRUD/conexao.php';

// Verifica se o usuário está logado e é um administrador
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['dados']['tipo_user'] !== "Administrador") {
    header('Location: ../index.php');
    exit();
}

// Verifica se o ID do usuário foi passado na URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idUsuario = $_GET['id'];

    // Consulta para obter os dados do usuário
    $sql = "SELECT * FROM cadastro WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Se o usuário não for encontrado
    if ($resultado->num_rows == 0) {
        header('Location: dashboard_admin.php?msg=erro_usuario_nao_encontrado');
        exit();
    }

    $usuario = $resultado->fetch_assoc();
} else {
    header('Location: dashboard_admin.php?msg=erro_id_invalido');
    exit();
}

// Atualiza os dados do usuário se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tipo_user = $_POST['tipo_user'];

    // Atualiza os dados no banco de dados
    $sqlUpdate = "UPDATE cadastro SET nome = ?, email = ?, tipo_user = ? WHERE id = ?";
    $stmtUpdate = $conexao->prepare($sqlUpdate);
    $stmtUpdate->bind_param("sssi", $nome, $email, $tipo_user, $idUsuario);

    if ($stmtUpdate->execute()) {
        header('Location: dashboard_admin.php?msg=sucesso_editar');
        exit();
    } else {
        header('Location: dashboard_admin.php?msg=erro_editar');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <style>
        /* Estilo básico, pode ser ajustado conforme necessário */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #FF5722;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 15px;
            background-color: #FF5722;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #E64A19;
        }
        a {
            text-decoration: none;
            color: #FF5722;
        }
    </style>
</head>
<body>
    <h1>Editar Usuário</h1>
    <form action="editar_usuario.php?id=<?php echo $usuario['id']; ?>" method="POST">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>

        <label for="tipo_user">Tipo de Usuário</label>
        <select id="tipo_user" name="tipo_user" required>
            <option value="Administrador" <?php echo $usuario['tipo_user'] == 'Administrador' ? 'selected' : ''; ?>>Administrador</option>
            <option value="Instrutor" <?php echo $usuario['tipo_user'] == 'Instrutor' ? 'selected' : ''; ?>>Instrutor</option>
            <option value="Aluno" <?php echo $usuario['tipo_user'] == 'Aluno' ? 'selected' : ''; ?>>Aluno</option>
        </select>

        <button type="submit">Salvar Alterações</button>
    </form>
    <a href="dashboard_admin.php">Voltar para o Dashboard</a>
</body>
</html>
