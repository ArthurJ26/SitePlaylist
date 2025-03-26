<?php
session_start();
include '../back-end/conexao.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT id, nome, email, is_admin FROM usuarios";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" type="text/css" href="users.css" />
    <meta charset="UTF-8">
    <title>Gerenciar Usuários</title>
</head>
<body>
    <h1>Gerenciar Usuários</h1>

    <?php
    if ($result->num_rows > 0) {
        while ($user = $result->fetch_assoc()) {
            echo '<div class="user-item">';

            echo '<div class="user-info">';
            echo '<strong>Nome:</strong> ' . htmlspecialchars($user['nome']) . '<br>';
            echo '<strong>Email:</strong> ' . htmlspecialchars($user['email']) . '<br>';
            echo '<strong>Admin:</strong> ' . ($user['is_admin'] ? 'Sim' : 'Não');
            echo '</div>';

            echo '<form method="POST" action="../back-end/delete_user.php">';
            echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($user['id']) . '">';
            echo '<button type="submit" class="delete-button">Deletar</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "<p>Nenhum usuário encontrado.</p>";
    }

    $conexao->close();
    ?>

    <br>
    <a href="paginaprincipal.php">Voltar para a página principal</a>
</body>
</html>
