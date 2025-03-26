<?php
session_start();
include 'conexao.php';

header("Content-Type: application/json");

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["error" => "Usuário não autenticado."]);
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$is_admin = $_SESSION['is_admin'];

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
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($is_admin) {

        $sql = "SELECT videos.*, usuarios.nome as usuario_nome FROM videos 
                JOIN usuarios ON videos.usuario_id = usuarios.id";
    } else {

        $sql = "SELECT * FROM videos WHERE usuario_id = $usuario_id";
    }
    $result = $conexao->query($sql);

    $videos = [];
    while ($row = $result->fetch_assoc()) {
        $videos[] = $row;
    }
    echo json_encode($videos);
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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $is_admin) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['nome']) && isset($data['email']) && isset($data['senha'])) {
        $nome = $conexao->real_escape_string($data['nome']);
        $email = $conexao->real_escape_string($data['email']);
        $senha = password_hash($data['senha'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        
        if ($conexao->query($sql) === TRUE) {
            echo json_encode(["message" => "Usuário cadastrado com sucesso"]);
        } else {
            echo json_encode(["error" => "Erro ao cadastrar usuário: " . $conexao->error]);
        }
    } else {
        echo json_encode(["error" => "Dados inválidos"]);
    }
}

$conexao->close();
?>

