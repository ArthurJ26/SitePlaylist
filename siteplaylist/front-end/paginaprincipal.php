<?php
session_start();
include '../back-end/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update' && isset($_POST['video_id']) && isset($_POST['new_video_url'])) {
        $video_id = $_POST['video_id'];
        $new_video_url = $conexao->real_escape_string($_POST['new_video_url']);

        preg_match('/(?:https?:\/\/(?:www\.)?youtube\.com\/.*v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $new_video_url, $matches);
        if (isset($matches[1])) {
            $new_thumbnail_url = "https://img.youtube.com/vi/{$matches[1]}/maxresdefault.jpg";

            $update_sql = "UPDATE videos SET video_url = '$new_video_url', thumbnail_url = '$new_thumbnail_url' WHERE id = $video_id AND usuario_id = $usuario_id";
            $conexao->query($update_sql);
        }
    } elseif ($_POST['action'] === 'delete' && isset($_POST['video_id'])) {
        $video_id = $_POST['video_id'];
        
        $delete_sql = "DELETE FROM videos WHERE id = $video_id AND usuario_id = $usuario_id";
        $conexao->query($delete_sql);
    }
}

$sql = "SELECT * FROM videos WHERE usuario_id = $usuario_id";
$result = $conexao->query($sql);

$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
</head>
<body>

    <header id="header">
        <div class="container-header">
            <div class="flex">
                <nav>
                    <ul class="primary-navigation">
                        <h2>Bem-vindo, <?php echo $_SESSION['usuario_nome']; ?>!</h2>
                        <div class="options">
                            <li><a href="../back-end/logout.php">Sair</a></li>
                            <li><a href="editar_perfil.php">Alterar Perfil</a></li>
                            <?php if ($is_admin): ?>
                                <li><a href="cadastro_usuario.php">Cadastrar Novo Usuário</a></li>
                                <li><a href="historico_videos.php">Ver Histórico de Vídeos</a></li>
                                <li><a href="gerenciar_usuarios.php">Gerenciar Usuarios</a></li>
                            <?php endif; ?>

                        </div>
                    </ul>
                </nav>
            </div>    
        </div>
    </header>

<div class="a">
    <div class="container">
        <h1>Salve Vídeos do YouTube</h1>
        <input type="text" id="youtube-url" placeholder="Cole a URL do vídeo do YouTube aqui" />
        <button onclick="saveVideo()">Salvar Vídeo</button>
    </div>

    <div id="feed">
        <?php
        if ($result->num_rows > 0) {
            while ($video = $result->fetch_assoc()) {
                echo '<div class="video-item">';
                echo '<a href="' . htmlspecialchars($video['video_url']) . '" target="_blank">';
                echo '<img src="' . htmlspecialchars($video['thumbnail_url']) . '" alt="Thumbnail do vídeo" class="thumbnail">';
                echo '</a>';

                echo '<form method="POST" action="" class="alter-url-form">';
                echo '<input type="hidden" name="video_id" value="' . $video['id'] . '">';
                echo '<input type="hidden" name="action" value="update">';
                echo '<input type="text" name="new_video_url" placeholder="Nova URL do vídeo" required>';
                echo '<button type="submit">Alterar URL</button>';
                echo '</form>';

                echo '<form method="POST" action="" class="delete-form" onsubmit="return confirm(\'Tem certeza que deseja deletar este vídeo?\');">';
                echo '<input type="hidden" name="video_id" value="' . $video['id'] . '">';
                echo '<input type="hidden" name="action" value="delete">';
                echo '<button type="submit">Deletar</button>';
                echo '</form>';

                echo '</div>';
            }
        } else {
            echo "<p>Nenhum vídeo salvo ainda.</p>";
        }
        ?>
    </div>
</div>
<script src="script.js"></script>

</body>
</html>

<?php $conexao->close(); ?>
