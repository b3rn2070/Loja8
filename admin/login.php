<?php
session_start();
if (isset($_SESSION["logadoAdm"]) && $_SESSION["logadoAdm"] == 1) {
    header("Location: index.php");
} 
require_once '../classes/conexao.php';
require_once '../classes/admFunc.php';

$login = new admFunc();
$conn = new Conexao("localhost", "root", "", "loja8");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<center>
    <h1>Login adm</h1>
    <form action="login.php" method="post">
        <p><input type="text" placeholder="email" name="email" required></p>
        <p><input type="password" placeholder="senha" name="senha" maxlength="16" minlength="8" required></p>
        <p><input type="submit" value="login"></p>
    </form>

    <?php 
        if(isset($_POST['email']) && isset($_POST['senha'])){
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            if($login->logar($email, $senha) == false){
                echo "<script>confirm('Usuário e/ou senha inválidos e/ou você não possui cadastro');</script> </h4>";
            } else {
                $_SESSION["logadoAdm"] = 1;
                header("Location: index.php");
                exit;
            }
        }
    ?>
</center>
</body>
</html>