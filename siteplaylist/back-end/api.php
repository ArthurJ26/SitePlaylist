<?php
session_start();
include 'conexao.php';

header("Content-Type: application/json");

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["error" => "Usuário não autenticado."]);
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['video_url']) && isset($data['thumbnail_url'])) {
        $videoUrl = $conexao->real_escape_string($data['video_url']);
        $thumbnailUrl = $conexao->real_escape_string($data['thumbnail_url']);

        $sql = "INSERT INTO videos (video_url, thumbnail_url, usuario_id) VALUES ('$videoUrl', '$thumbnailUrl', $usuario_id)";
        
        if ($conexao->query($sql) === TRUE) {
            echo json_encode(["message" => "Vídeo adicionado com sucesso"]);
        } else {
            echo json_encode(["error" => "Erro ao adicionar vídeo: " . $conexao->error]);
        }
    } else {
        echo json_encode(["error" => "Dados inválidos"]);
    }
    exit(); 
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM videos WHERE usuario_id = $usuario_id";
    $result = $conexao->query($sql);

    $videos = [];
    while ($row = $result->fetch_assoc()) {
        $videos[] = $row;
    }

    echo json_encode($videos);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['video_id'], $data['new_video_url'], $data['new_thumbnail_url'])) {
    $videoId = $conexao->real_escape_string($data['video_id']);
    $newVideoUrl = $conexao->real_escape_string($data['new_video_url']);
    $newThumbnailUrl = $conexao->real_escape_string($data['new_thumbnail_url']);

    $sql = "UPDATE videos SET video_url = '$newVideoUrl', thumbnail_url = '$newThumbnailUrl' WHERE id = $videoId AND usuario_id = $usuario_id";
    
    if ($conexao->query($sql) === TRUE) {
        echo json_encode(["message" => "URL do vídeo atualizada com sucesso"]);
    } else {
        echo json_encode(["error" => "Erro ao atualizar o vídeo: " . $conexao->error]);
    }
    exit();
}


$conexao->close();

?>