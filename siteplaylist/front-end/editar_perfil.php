<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php"); 
    exit();
}

include '../back-end/conexao.php';

$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT nome, email FROM usuarios WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="cadastro.css" />
    <title>Editar Perfil</title>
</head>
<body>

    <form action="../back-end/processa_edicao.php" method="post">
        <h2>Editar Perfil</h2>

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required><br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required><br><br>

        <label for="senha">Nova Senha:</label>
        <input type="password" id="senha" name="senha"><br><br>

        <button type="submit">Salvar Alterações</button>

        <a href="paginaprincipal.php">Voltar para a página principal</a>
    </form> 
</body>
</html>
