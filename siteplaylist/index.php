<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="front-end/cadastro.css" />
    <title>Login</title>
</head>
<body>

<img src="img/myvideologo.png"></img>
    
    <form action="back-end/processa_login.php" method="post">
        
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>

        <p>Faça seu Cadastro: <a href="front-end/cadastro.php">Clique Aqui</a></p>

        <button type="submit">Entrar</button>
    </form>

</body>
</html>

