<?php
session_start();
include '../CRUD/conexao.php';

// Verifica se o usuário está logado e é um instrutor
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['dados']['tipo_user'] !== "Instrutor") {
    header('Location: ../index.php');
    exit();
}

// Obtém os dados do usuário logado
$idUsuario = $_SESSION['dados']['id'];
$nomeUsuario = $_SESSION['dados']['nome'];
$emailUsuario = $_SESSION['dados']['email'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Instrutor</title>
    <!-- FontAwesome para ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* Reset de estilo e fontes */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #121212;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        header {
            background-color: #FF5722;
            color: white;
            width: 100%;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 2rem;
            margin-bottom: 5px;
        }

        header p {
            font-size: 1rem;
            color: #bbb;
        }

        main {
            max-width: 900px;
            width: 100%;
            margin: 20px;
            padding: 30px;
            background-color: #1c1c1c;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            color: #bbb;
        }

        main h2 {
            color: #FF9800;
            margin-bottom: 30px;
            font-size: 1.5rem;
            text-align: center;
            grid-column: span 3;
        }

        /* Estilo dos Cards */
        .card {
            background-color: #2c2c2c;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .card i {
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .card h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .card a {
            text-decoration: none;
            color: #FF5722;
            font-weight: bold;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .card a:hover {
            color: #E64A19;
        }

        footer {
            margin-top: 30px;
            font-size: 0.9rem;
            color: #bbb;
            text-align: center;
            width: 100%;
        }

        footer a {
            color: #FF5722;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Media Queries para responsividade */
        @media (max-width: 768px) {
            header h1 {
                font-size: 1.5rem;
            }

            main h2 {
                font-size: 1.2rem;
            }

            .card {
                padding: 15px;
            }

            .card i {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</h1>
        <p>Email: <?php echo htmlspecialchars($emailUsuario); ?></p>
    </header>

    <main>
        <h2>O que você deseja fazer hoje?</h2>
        <div class="card">
            <i class="fas fa-user-plus"></i>
            <h3>Cadastrar Aluno</h3>
            <p>Adicione novos alunos à plataforma.</p>
            <a href="cadastro_aluno.php">Ir para Cadastro</a>
        </div>

        <div class="card">
            <i class="fas fa-users-cog"></i>
            <h3>Gerenciar Alunos</h3>
            <p>Visualize e edite os alunos cadastrados.</p>
            <a href="gerenciar_alunos.php">Ir para Gerenciamento</a>
        </div>

        <div class="card">
            <i class="fas fa-dumbbell"></i>
            <h3>Gerenciar Séries e Exercícios</h3>
            <p>Crie e edite séries e exercícios para seus alunos.</p>
            <a href="gerenciar_series.php">Ir para Gerenciamento</a>
        </div>

        <div class="card">
            <i class="fas fa-cogs"></i>
            <h3>Gerenciar Equipamentos</h3>
            <p>Gerencie os equipamentos disponíveis na plataforma.</p>
            <a href="gerenciar_equipamentos.php">Ir para Gerenciamento</a>
        </div>

        <div class="card">
            <i class="fas fa-file-alt"></i>
            <h3>Gerar Relatórios</h3>
            <p>Crie relatórios sobre o desempenho dos alunos.</p>
            <a href="relatorios.php">Ir para Relatórios</a>
        </div>

        <div class="card">
            <i class="fas fa-chart-line"></i>
            <h3>Visualizar Dashboard Analítico</h3>
            <p>Veja o desempenho geral da plataforma.</p>
            <a href="dashboard_analitico.php">Ir para Dashboard</a>
        </div>
    </main>

    <footer>
        <a href="../CRUD/logout.php">Sair</a>
    </footer>
</body>
</html>
