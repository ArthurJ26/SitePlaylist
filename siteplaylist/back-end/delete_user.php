<?php
session_start();
include '../back-end/conexao.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']); 

    if ($user_id == $_SESSION['usuario_id']) {
        $_SESSION['error_message'] = "Você não pode excluir sua própria conta.";
        header("Location: ../front-end/gerenciar_usuarios.php");
        exit();
    }

    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Usuário deletado com sucesso.";
    } else {
        $_SESSION['error_message'] = "Erro ao deletar o usuário.";
    }

    $stmt->close();
    $conexao->close();

    header("Location: ../front-end/gerenciar_usuarios.php");
    exit();
} else {
    header("Location: ../front-end/gerenciar_usuarios.php");
    exit();
}
