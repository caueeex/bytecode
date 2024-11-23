<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificação na tabela 'cadastro'
    $consultaCadastro = $conexao->prepare("SELECT * FROM cadastro WHERE email = ?");
    $consultaCadastro->bind_param("s", $email);
    $consultaCadastro->execute();
    $resultadoCadastro = $consultaCadastro->get_result();

    if ($resultadoCadastro->num_rows > 0) {
        $row = $resultadoCadastro->fetch_assoc();

        if (password_verify($senha, $row['senha'])) {
            $_SESSION["logado"] = true;
            $_SESSION["dados"] = [
                'id' => $row['id'], // ID do usuário
                'nome' => $row['nome'],
                'email' => $row['email'],
                'tipo_user' => $row['tipo_user']
            ];

            // Redirecionamento baseado no tipo de usuário
            if ($row['tipo_user'] == "Administrador") {
                header("Location: ../pageAdmin/dashboard_admin.php");
                exit();
            }  else if ($row['tipo_user'] == "Instrutor") {
                header("Location: ../pageInstrutor/dashboard_instrutor.php");
                exit();
            }
        } else {
            header("Location:../admin.php?error=senha_incorreta");
            exit();
        }
    } else {
        // Verificação na tabela 'alunos'
        $consultaAlunos = $conexao->prepare("SELECT * FROM alunos WHERE email = ?");
        $consultaAlunos->bind_param("s", $email);
        $consultaAlunos->execute();
        $resultadoAlunos = $consultaAlunos->get_result();

        if ($resultadoAlunos->num_rows > 0) {
            $rowAluno = $resultadoAlunos->fetch_assoc();

            if (password_verify($senha, $rowAluno['senha'])) {
                $_SESSION["logado"] = true;
                $_SESSION["dados"] = [
                    'id' => $rowAluno['id'], // ID do aluno
                    'nome' => $rowAluno['nome'],
                    'email' => $rowAluno['email'],
                    'tipo_user' => "Aluno" // Define o tipo como 'Aluno'
                ];

                header("Location: ../pageAluno/dashboard_aluno.php");
                exit();
            } else {
                header("Location:../admin.php?error=senha_incorreta");
                exit();
            }
        } else {
            header("Location:../admin.php?error=email_nao_encontrado");
            exit();
        }
    }
}
?>
