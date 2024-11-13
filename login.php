<?php
session_start();
require_once 'classes/conexao.php';
require_once 'classes/login.php';

if (isset($_SESSION["logado"]) && $_SESSION["logado"] == 1) {
    header("Location: index.php");
} ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<center>
<section class="formulario-container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="E-mail" required>
            </div>
            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Senha" required>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn-submit">Enviar</button>
            </div>
        </form>
    </section>
    <h4>Caso não possua cadastro <a href="cadastro.php"> clique aqui </a></h4>

    <?php
        if(isset($_POST['email']) && isset($_POST['senha'])){
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $login = new Login($email, $senha);
            $login->logar();

            if($login->logar() == false){
                echo "<script>confirm('Usuário e/ou senha inválidos');</script>";
            }
        }
        ?>
</center>
</body>
</html>