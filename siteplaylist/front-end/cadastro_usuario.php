<?php
session_start();
include '../back-end/conexao.php';

if (!isset($_SESSION['usuario_id']) || !$_SESSION['is_admin']) {
    header("Location: paginaprincipal.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $conexao->real_escape_string($_POST['nome']);
    $email = $conexao->real_escape_string($_POST['email']);
    $senha = $conexao->real_escape_string($_POST['senha']);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $sql = "INSERT INTO usuarios (nome, email, senha, is_admin) VALUES ('$nome', '$email', '$senha', $is_admin)";

    if ($conexao->query($sql) === TRUE) {
        $mensagem = "Usuário cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar usuário: " . $conexao->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="cadastro.css" />
    <title>Cadastrar Novo Usuário</title>
</head>
<body>
    <h2>Cadastrar Novo Usuário</h2>

    <?php if (isset($mensagem)) { echo "<p>$mensagem</p>"; } ?>

    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>

        <label for="is_admin">Administrador:</label>
        <input type="checkbox" id="is_admin" name="is_admin"><br>

        <button type="submit">Cadastrar Usuário</button>
    </form>
</br>
    <a href="paginaprincipal.php">Voltar para a página principal</a>
</body>
</html>

