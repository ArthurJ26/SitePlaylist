<?php
session_start();
include 'conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE email = ? AND senha = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ss", $email, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    $_SESSION['usuario_id'] = $user['id'];
    $_SESSION['usuario_nome'] = $user['nome'];
    $_SESSION['is_admin'] = $user['is_admin']; 

    header("Location: ../front-end/paginaprincipal.php");
    exit(); 
} else {

    header("Location: login.php?error=Credenciais inválidas");
    exit();
}
?>
