<?php
include '../CRUD/conexao.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['dados']['tipo_user'] !== "Instrutor") {
    header('Location: ../index.php');
    exit();
}

// Processa os dados do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $data_nascimento = $_POST['data_nascimento'];
    $telefone = $_POST['telefone'];

    $sql = "INSERT INTO alunos (nome, email, senha, data_nasc, telefone, fk_id_instrutor) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssssi", $nome, $email, $senha, $data_nascimento, $telefone, $_SESSION['dados']['id']);
    
    if ($stmt->execute()) {
        header('Location: dashboard_instrutor.php');
    } else {
        echo "Erro ao cadastrar aluno: " . $conexao->error;
    }
}
?>
