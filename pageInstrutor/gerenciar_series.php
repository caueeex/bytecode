<?php
session_start();
include '../CRUD/conexao.php';

// Verifica se o usuário está logado e é um instrutor
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['dados']['tipo_user'] !== "Instrutor") {
    header('Location: ../index.php');
    exit();
}

// Obtém o ID do instrutor logado
$instrutor_id = $_SESSION['dados']['id'];

// Verifica se foi feita uma solicitação para excluir uma série
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['acao'])) {
    $acao = $_POST['acao'];

    if ($acao == 'excluir' && isset($_POST['id'])) {
        $id = $_POST['id'];

        // Excluir série do banco de dados
        $sql_excluir = "DELETE FROM series WHERE id = ? AND instrutor_id = ?";
        $stmt_excluir = $conexao->prepare($sql_excluir);
        $stmt_excluir->bind_param("ii", $id, $instrutor_id);

        if ($stmt_excluir->execute()) {
            header("Location: gerenciar_series.php?msg=sucesso_excluir");
            exit();
        } else {
            header("Location: gerenciar_series.php?msg=erro_excluir");
            exit();
        }
    }
}

// Consulta para obter todas as séries do instrutor logado
$sql_series = "SELECT * FROM series WHERE instrutor_id = ?";
$stmt_series = $conexao->prepare($sql_series);
$stmt_series->bind_param("i", $instrutor_id);
$stmt_series->execute();
$result_series = $stmt_series->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Séries</title>
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

        /* Estilo da Tabela */
        table {
            width: 80%;
            margin: 50px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #444;
        }

        th {
            background-color: #333;
            color: #FF9800;
        }

        td {
            background-color: #222;
        }

        /* Botão de Excluir */
        button {
            background-color: #FF5722;
            border: none;
            color: white;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #E64A19;
        }

        /* Mensagens */
        .alert {
            background-color: #333;
            color: #FF9800;
            text-align: center;
            padding: 10px;
            margin: 20px;
            border-radius: 5px;
        }

        /* Formulário e Links */
        .container {
            width: 80%;
            margin: 20px auto;
        }

        .btn {
            background-color: #FF9800;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            display: inline-block;
        }

        .btn:hover {
            background-color: #FF5722;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciar Séries</h1>

        <!-- Mensagens de Sucesso ou Erro -->
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert">
                <?php
                switch ($_GET['msg']) {
                    case 'sucesso_excluir':
                        echo "Série excluída com sucesso!";
                        break;
                    case 'erro_excluir':
                        echo "Erro ao excluir a série.";
                        break;
                    case 'sucesso_adicionar':
                        echo "Série adicionada com sucesso!";
                        break;
                    case 'erro_adicionar':
                        echo "Erro ao adicionar a série.";
                        break;
                    case 'erro_editar':
                        echo "Erro ao editar a série.";
                        break;
                }
                ?>
            </div>
        <?php endif; ?>

        <!-- Botão para adicionar uma nova série -->
        <a href="adicionar_serie.php" class="btn">Adicionar Nova Série</a>
        <br><br>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome da Série</th>
                    <th>Descrição</th>
                    <th>Quantidade de Exercícios</th>
                    <th>Data de Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($serie = $result_series->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $serie['id']; ?></td>
                        <td><?php echo $serie['nome']; ?></td>
                        <td><?php echo $serie['descricao']; ?></td>
                        <td><?php echo $serie['quantidade_exercicios']; ?></td>
                        <td><?php echo $serie['data_criacao']; ?></td>
                        <td>
                            <a href="editar_serie.php?id=<?php echo $serie['id']; ?>">Editar</a> | 
                            <form action="gerenciar_series.php" method="POST" style="display:inline;">
                                <input type="hidden" name="acao" value="excluir">
                                <input type="hidden" name="id" value="<?php echo $serie['id']; ?>">
                                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir esta série?');">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <br>
        <a href="dashboard_instrutor.php" class="btn">Voltar ao Dashboard</a>
    </div>
</body>
</html>
