<?php
require_once 'classes/conexao.php';
require_once 'classes/cadastro.php';
session_start();
if ((isset($_SESSION["logado"])) && ($_SESSION["logado"] == 1)) {
    header("Location: index.php");
}
$conn = new Conexao("localhost", "root", "", "loja8");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <center>
        <h2>Cadastro</h2>
        <form action="cadastro.php" method="post" onsubmit="verificarDados()">
            <p><input type="text" placeholder="nome" name="nome" id="input-nome" required></p>
            <p><input type="text" placeholder="email" name="email" required></p>
            <p><input type="password" placeholder="senha" name="senha" id="input-senha" required></p>
            <p><input type="text" placeholder="cpf" name="cpf" id="input-cpf" minlength="11" maxlength="11" required></p>
            <p><input type="submit" value="cadastrar"></p>
        </form>
    </center>
    <script>
        function verificarDados() {
            let nome = document.getElementById("input-nome").value;
            let senha = document.getElementById("input-senha").value;
            let cpf = document.getElementById("input-cpf").value;

            if (nome.length < 3) {
                confirm("O nome deve ter no mínimo 3 caracteres!");

                document.getElementById("input-nome").focus();
                window.onsubmit = function() {
                    return false;
                };
            } else if (senha.length < 6) {
                confirm("A senha deve ter no mínimo 6 caracteres!");

                document.getElementById("input-senha").focus();
                window.onsubmit = function() {
                    return false;
                };
            } else if (cpf.length != 11) {
                confirm("Cpf deve conter 11 caracteres");

                document.getElementById("input-cpf").focus();
                window.onsubmit = function() {
                    return false;
                };
            } else {
                return true;
            }
        }
    </script>

    <?php
    if (isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["senha"]) && isset($_POST["cpf"])) {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $senha = password_hash($senha, PASSWORD_BCRYPT);
        $cpf = $_POST["cpf"];

        $cadastro = new Cadastro($nome, $email, $senha, $cpf);

        if ($cadastro->verificarEmail() == true) {
            if ($cadastro->verificarCpfBD() == false) {
                $cadastro->cadastrar();
            ?> <script>
                    const usrResp = confirm('Cadastrado com sucesso!');

                    if (usrResp) {
                        window.location.href = "login.php";
                    }
                    
            </script> <?php
                        } else if ($cadastro->verificarCpfBD() == true) {
                            echo "<script> confirm('CPF já cadastrado') </script>";
                        }
                    } else {
                        echo "<script> confirm('Email inválido') </script>";
                    }
                }
                            ?>

</body>

</html>