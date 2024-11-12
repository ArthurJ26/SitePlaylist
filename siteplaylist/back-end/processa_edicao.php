<?php

session_start();


if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../front-end/index.php"); 
    exit();
}

include 'conexao.php';

$usuario_id = $_SESSION['usuario_id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

if (!empty($senha)) {   
    $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssi", $nome, $email, $senha, $usuario_id);
} else {
    $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssi", $nome, $email, $usuario_id);
}

if ($stmt->execute()) {
    echo "Perfil atualizado com sucesso!";
    header("Location: ../front-end/paginaprincipal.php");
    exit();
} else {
    echo "Erro ao atualizar perfil: " . $stmt->error;
}

$stmt->close();
$conexao->close();
?>
