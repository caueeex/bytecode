<?php
session_start();
include '../CRUD/conexao.php';

// Verifica se o usuário está logado e é um instrutor
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['dados']['tipo_user'] !== "Instrutor") {
    header('Location: ../index.php');
    exit();
}

// Verifica se o ID do equipamento foi passado e é válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $instrutor_id = $_SESSION['dados']['id']; // ID do instrutor logado

    // Verifica se o equipamento pertence ao instrutor logado
    $sql_verifica = "SELECT id FROM equipamentos WHERE id = ? AND instrutor_id = ?";
    $stmt_verifica = $conexao->prepare($sql_verifica);
    $stmt_verifica->bind_param("ii", $id, $instrutor_id);
    $stmt_verifica->execute();
    $result = $stmt_verifica->get_result();

    // Se o equipamento não for encontrado ou não pertencer ao instrutor, exibe erro
    if ($result->num_rows === 0) {
        header("Location: gerenciar_equipamentos.php?msg=erro_equipamento_nao_encontrado");
        exit();
    }

    // Exclui o equipamento
    $sql = "DELETE FROM equipamentos WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: gerenciar_equipamentos.php?msg=sucesso_excluir");
        exit();
    } else {
        header("Location: gerenciar_equipamentos.php?msg=erro_excluir");
        exit();
    }
} else {
    // Se o ID não for passado corretamente, redireciona com erro
    header("Location: gerenciar_equipamentos.php?msg=erro_id_invalido");
    exit();
}
?>
