<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon">
    <title>VANN Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/login.css">
</head>
<style>
    .social-icons img {
    width: 100px;
    margin-bottom: 20px;
}

span {
    display: block;
    margin-bottom: 15px;
    font-size: 14px;
    color: #555;
}

</style>
<body>
    <div class="container">
        <div class="login-form">
            <form action="./CRUD/valida_login.php" method="post">
                <div class="logo">
                    <a href="index.php">
                    <img src="./assets/img/logo.jpg" width="50%" alt="Logo">
                    </a>
                </div>
                <h2>Entrar</h2>
                <div class="input-group">
                    <input type="email" placeholder="Email" name="email" required>
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Senha" name="senha" required>
                    <i class="fas fa-lock"></i>
                </div>
                <a href="../sitevann-php/esqueci_minha_senha.php">Esqueceu sua senha?</a><br>
                <button type="submit">Entrar</button>
            </form>
            <p>Não tem uma conta? <a href="cadastrar.php">Registrar-se</a></p>
        </div>
    </div>

    <script src="./assets/js/script.js"></script>
</body>
</html>