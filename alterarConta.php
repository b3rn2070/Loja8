<?php
session_start();
if (!isset($_SESSION['logado'])) { ?>
    <script>
        const usrResp = confirm("você precisa fazer login");

        if (usrResp) {
            window.location.href = "login.php";
        }
    </script>
<?php } else { ?>
    <?php
    require_once 'classes/conexao.php';
    require_once 'classes/cliente.php';
    $usr = new Cliente($_SESSION['idCliente']);
    ?>


    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Alterar Conta</title>
        <link rel="stylesheet" href="style.css">

    </head>

    <body>
        <?php
        if (isset($_REQUEST['nome']) && isset($_REQUEST['email']) && isset($_REQUEST['senha'])) {
            $nome = $_REQUEST['nome'];
            $email = $_REQUEST['email'];
            $senha = $_REQUEST['senha'];
            $senha = password_hash($senha, PASSWORD_BCRYPT);
            $idCli = $_SESSION['idCliente'];

            $conn = new Conexao("localhost", "root", "", "loja8");
            $conn->conectar();

            if ($usr->verificarEmail($email)) {
                $usr->alterarConta($nome, $email, $senha);
                echo "<script> alert('Conta alterada com sucesso!') </script>";
            } else {
                echo "<script> alert('Email incoerente!') </script>";
            }
        }

        ?>
        <center>
            <h3> Alteração da Conta </h3>
            <form action="alterarConta.php" method="post" onsubmit="verificarDados()">
                <p>Nome: <input type="text" name="nome" id="input-nome" value="<?php echo $usr->getNome(); ?>"> </p>
                <p>Email: <input type="text" name="email" id="input-email" value="<?php echo $usr->getEmail(); ?>"> </p>
                <p>Senha: <input type="password" name="senha" id="input-senha"> </p>
                <p>
                    <input type="submit" value="Alterar">
                </p>
            </form>
            <form action="index.php" method="post">
                <input type="submit" value="Voltar">
            </form>


        </center>
        <script>
            function verificarDados() {
                let nome = document.getElementById("input-nome").value;
                let senha = document.getElementById("input-senha").value;

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
                } else {
                    return true;
                }
            }
        </script>
    </body>

    </html>
<?php } ?>