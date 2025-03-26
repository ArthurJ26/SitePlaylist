<?php
session_start();
include '../back-end/conexao.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['video_id'])) {
    $video_id = intval($_POST['video_id']); 

    $sql = "DELETE FROM videos WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $video_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Vídeo deletado com sucesso.";
    } else {
        $_SESSION['error_message'] = "Erro ao deletar o vídeo.";
    }

    $stmt->close();
    $conexao->close();

    header("Location: ../front-end/historico_videos.php");
    exit();
} else {
    header("Location: ../front-end/historico_videos.php");
    exit();
}
