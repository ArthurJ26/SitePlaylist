<?php

session_start();

include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        if ($senha === $usuario['senha']) {

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];

            header("Location: ../front-end/paginaprincipal.php");
            exit();
        } else {
            header("Location: ../index.php?erro=senha_incorreta");
            exit();
        }
    } else {
        header("Location: ../index.php?erro=email_nao_encontrado");
        exit();
    }

    $stmt->close();
    $conexao->close();
} else {
    echo "Método de requisição inválido.";
}
?>


