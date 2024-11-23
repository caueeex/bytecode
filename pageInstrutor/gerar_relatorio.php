<?php
session_start();
include '../CRUD/conexao.php';

// Verifica se o usuário está logado e é um instrutor
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['dados']['tipo_user'] !== "Instrutor") {
    header('Location: ../index.php');
    exit();
}

// Obtém os parâmetros do formulário
$tipoRelatorio = isset($_GET['tipo_relatorio']) ? $_GET['tipo_relatorio'] : '';
$dataInicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
$dataFim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';

// Construir a query de acordo com o tipo de relatório
switch ($tipoRelatorio) {
    case 'alunos':
        // Relatório de alunos
        $sql = "SELECT id, nome, email, data_nasc, telefone FROM alunos WHERE fk_id_instrutor = ?";
        $params = [$_SESSION['dados']['id']];
        
        if ($dataInicio && $dataFim) {
            $sql .= " AND data_nasc BETWEEN ? AND ?";
            $params[] = $dataInicio;
            $params[] = $dataFim;
        }
        
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $tituloRelatorio = "Relatório de Alunos";
        $cabecalhos = ['ID', 'Nome', 'Email', 'Data de Nascimento', 'Telefone'];
        $dadosRelatorio = [];
        while ($aluno = $resultado->fetch_assoc()) {
            $dadosRelatorio[] = $aluno;
        }
        break;
        
    case 'equipamentos':
        // Relatório de equipamentos
        $sql = "SELECT id, nome, descricao, quantidade, status FROM equipamentos WHERE fk_id_instrutor = ?";
        $params = [$_SESSION['dados']['id']];
        
        if ($dataInicio && $dataFim) {
            $sql .= " AND data_aquisicao BETWEEN ? AND ?";
            $params[] = $dataInicio;
            $params[] = $dataFim;
        }

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $tituloRelatorio = "Relatório de Equipamentos";
        $cabecalhos = ['ID', 'Nome', 'Descrição', 'Quantidade', 'Status'];
        $dadosRelatorio = [];
        while ($equipamento = $resultado->fetch_assoc()) {
            $dadosRelatorio[] = $equipamento;
        }
        break;
        
    case 'series':
        // Relatório de séries e exercícios
        $sql = "SELECT s.id, s.nome AS serie_nome, e.nome AS exercicio_nome, e.repeticoes, e.series 
                FROM series s
                JOIN exercicios e ON e.series_id = s.id
                WHERE s.instrutor_id = ?";
        $params = [$_SESSION['dados']['id']];
        
        if ($dataInicio && $dataFim) {
            $sql .= " AND s.data_criacao BETWEEN ? AND ?";
            $params[] = $dataInicio;
            $params[] = $dataFim;
        }

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $tituloRelatorio = "Relatório de Séries e Exercícios";
        $cabecalhos = ['ID', 'Série', 'Exercício', 'Repetições', 'Séries'];
        $dadosRelatorio = [];
        while ($serie = $resultado->fetch_assoc()) {
            $dadosRelatorio[] = $serie;
        }
        break;

    case 'relatorio_geral':
        // Relatório geral (alunos e equipamentos)
        $tituloRelatorio = "Relatório Geral";
        $cabecalhos = ['ID', 'Nome', 'Descrição', 'Quantidade', 'Status'];
        
        // Aqui você pode combinar os dados de alunos e equipamentos, por exemplo
        // Para simplificação, estamos buscando os equipamentos
        $sql = "SELECT id, nome, descricao, quantidade, status FROM equipamentos WHERE fk_id_instrutor = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $_SESSION['dados']['id']);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $dadosRelatorio = [];
        while ($equipamento = $resultado->fetch_assoc()) {
            $dadosRelatorio[] = $equipamento;
        }
        break;

    default:
        // Caso o tipo de relatório não seja válido
        echo "Tipo de relatório inválido.";
        exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tituloRelatorio); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #FF5722;
            color: white;
            padding: 20px;
            text-align: center;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #FF5722;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        footer {
            margin-top: 20px;
            text-align: center;
        }

        footer a {
            color: #FF5722;
            text-decoration: none;
        }
    </style>
</head>
<body>

<header>
    <h1><?php echo htmlspecialchars($tituloRelatorio); ?></h1>
</header>

<main>
    <table>
        <thead>
            <tr>
                <?php foreach ($cabecalhos as $cabecalho): ?>
                    <th><?php echo htmlspecialchars($cabecalho); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dadosRelatorio as $linha): ?>
                <tr>
                    <?php foreach ($linha as $valor): ?>
                        <td><?php echo htmlspecialchars($valor); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<footer>
    <a href="relatorios.php">Voltar</a>
</footer>

</body>
</html>
