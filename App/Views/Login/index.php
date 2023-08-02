<?php
if (isset($_SESSION['logado'])) {
    header('Location: /users/index');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div id="site">
        <figure>
            <img src="images/logo.png" alt="Logo Markt Club">
        </figure>
        <form action="login/validar" method="post">
            <legend>FAÇA SEU LOGIN</legend>
            <p>Digite seu CPF no campo abaixo e clique em logar para fazer seu login.</p>

            <div class="input">
                <input type="number" id="input_login" placeholder="CPF" inputmode="numeric" name="login">
                <label for="input_login">CPF</label>
            </div>
            <div class="input">
                <input type="password" id="input_senha" placeholder="Senha" inputmode="numeric" name="senha">
                <label for="input_senha">Senha</label>
            </div>
            <div>
                <p>Login: 28388470078</p>
                <p>Senha: 123456</p>
            </div>

            <button id="loginButton" name="loginButton">LOGAR</button>
            <?php
            if (!empty($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
        </form>
    </div>
</body>

</html>