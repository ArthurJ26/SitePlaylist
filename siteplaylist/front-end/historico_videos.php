<?php
session_start();
include '../back-end/conexao.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT videos.*, usuarios.nome as usuario_nome FROM videos 
        JOIN usuarios ON videos.usuario_id = usuarios.id";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta charset="UTF-8">
    <title>Histórico de Vídeos</title>
</head>
<body>
    <h1>Histórico de Vídeos</h1>

    <?php
    if ($result->num_rows > 0) {
        while ($video = $result->fetch_assoc()) {
            echo '<div class="video-item">';

            echo '<a href="' . htmlspecialchars($video['video_url']) . '" target="_blank">';
            echo '<img src="' . htmlspecialchars($video['thumbnail_url']) . '" alt="Thumbnail do vídeo" class="thumbnail">';
            echo '</a>';
            echo '<div class="video-info">';
            echo '<div class="video-title">';
            echo '<strong>Vídeo:</strong> <a href="' . htmlspecialchars($video['video_url']) . '" target="_blank">Assistir</a>';
            echo '</div>';

            echo '<div class="usuario-info">';
            echo '<strong>Postado por:</strong> ' . htmlspecialchars($video['usuario_nome']);
            echo '</div>';
            echo '</div>';

            echo '<form method="POST" action="../back-end/delete_video.php" style="margin-left: 15px;">';
            echo '<input type="hidden" name="video_id" value="' . htmlspecialchars($video['id']) . '">';
            echo '<button type="submit" class="delete-button">Deletar</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "<p>Nenhum vídeo encontrado.</p>";
    }

    $conexao->close();
    ?>

    <br>
    <a href="paginaprincipal.php">Voltar para a página principal</a>
</body>
</html>

