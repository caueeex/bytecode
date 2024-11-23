<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background: linear-gradient(to right, #292826bb, #adadaa);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
            color: #000;
        }

        .container {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            padding: 40px 30px;
            text-align: center;
            color: #000;
        }

        h2 {
            color: #000;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 15px;
            padding-left: 15px;
            border-radius: 30px;
            border: 1px solid #000;
            background-color: #f9f9f9;
            font-size: 14px;
            outline: none;
            color: #000;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #000;
            border: none;
            border-radius: 30px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #333;
        }

        a {
            display: block;
            margin-top: 20px;
            font-size: 14px;
            color: #000;
            text-decoration: none;
            font-weight: 500;
        }

        p {
            margin-top: 20px;
            font-size: 14px;
            color: #000;
        }

        p a {
            color: #000;
            font-weight: 600;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .input-group input,
            .input-group select {
                font-size: 13px;
                padding: 12px;
            }

            button {
                font-size: 14px;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cadastro</h2>
        <form action="./CRUD/cadastrar.php" method="POST">
            <div class="input-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>

            <div class="input-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>

            
            <div class="input-group">
                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" required>
            </div>


            <div class="input-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <!-- <div class="input-group">
                <label for="nivel">Nível:</label>
                <select name="tipo_user" id="nivel">
                    <option value="Aluno">Aluno</option>
                    <option value="Instrutor">Instrutor</option>
                </select>
            </div> -->

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
