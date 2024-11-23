<?php
session_start();
include '../CRUD/conexao.php';

// Verifica se o usuário está logado e é um instrutor
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || $_SESSION['dados']['tipo_user'] !== "Instrutor") {
    header('Location: ../index.php');
    exit();
}

// Obtem o ID do instrutor logado
$instrutor_id = $_SESSION['dados']['id']; // ID do instrutor logado

// Verifica se uma ação foi enviada via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['acao'])) {
    $acao = $_POST['acao'];

    // Ação: Adicionar Equipamento
    if ($acao === 'adicionar') {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $quantidade = $_POST['quantidade'];
        $data_aquisicao = $_POST['data_aquisicao'];
        $status = $_POST['status'];

        $sql = "INSERT INTO equipamentos (nome, descricao, quantidade, data_aquisicao, status, instrutor_id) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssissi", $nome, $descricao, $quantidade, $data_aquisicao, $status, $instrutor_id);

        if ($stmt->execute()) {
            header("Location: gerenciar_equipamentos.php?msg=sucesso_adicionar");
            exit();
        } else {
            header("Location: gerenciar_equipamentos.php?msg=erro_adicionar");
            exit();
        }

    // Ação: Editar Equipamento
    } elseif ($acao === 'editar' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $quantidade = $_POST['quantidade'];
        $data_aquisicao = $_POST['data_aquisicao'];
        $status = $_POST['status'];

        $sql = "UPDATE equipamentos 
                SET nome = ?, descricao = ?, quantidade = ?, data_aquisicao = ?, status = ? 
                WHERE id = ? AND instrutor_id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssissii", $nome, $descricao, $quantidade, $data_aquisicao, $status, $id, $instrutor_id);

        if ($stmt->execute()) {
            header("Location: gerenciar_equipamentos.php?msg=sucesso_editar");
            exit();
        } else {
            header("Location: gerenciar_equipamentos.php?msg=erro_editar");
            exit();
        }

    // Ação: Excluir Equipamento
    } elseif ($acao === 'excluir' && isset($_POST['id'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM equipamentos WHERE id = ? AND instrutor_id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ii", $id, $instrutor_id);

        if ($stmt->execute()) {
            header("Location: gerenciar_equipamentos.php?msg=sucesso_excluir");
            exit();
        } else {
            header("Location: gerenciar_equipamentos.php?msg=erro_excluir");
            exit();
        }
    } else {
        header("Location: gerenciar_equipamentos.php?msg=acao_invalida");
        exit();
    }
} else {
    header("Location: gerenciar_equipamentos.php?msg=metodo_invalido");
    exit();
}
