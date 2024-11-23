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

    // Exclui o usuário da tabela 'cadastro'
    $sqlDelete = "DELETE FROM cadastro WHERE id = ?";
    $stmtDelete = $conexao->prepare($sqlDelete);
    $stmtDelete->bind_param("i", $idUsuario);

    if ($stmtDelete->execute()) {
        header('Location: dashboard_admin.php?msg=sucesso_excluir');
        exit();
    } else {
        header('Location: dashboard_admin.php?msg=erro_excluir');
        exit();
    }
} else {
    header('Location: dashboard_admin.php?msg=erro_id_invalido');
    exit();
}
