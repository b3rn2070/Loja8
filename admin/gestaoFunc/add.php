<?php
require_once '../../classes/conexao.php';
require_once '../../classes/admFunc.php';
session_start();

if (!isset($_SESSION['logadoAdm']) || $_SESSION['logadoAdm'] == 0) { ?>
    <script>
        const usrResp = confirm("você precisa fazer login");

        if (usrResp) {
            window.location.href = "../login.php";
        }
    </script>

<?php  } else if ($_SESSION['cargo'] == 'financeiro' || $_SESSION['cargo'] == 'estoquista') {
    header("Location: ../../admin/index.php");
} else {
?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Funcionario</title>
    </head>

    <body>
        <center>
            <form action="add.php" method="post" onsubmit="verificarDados()">
                <p><input type="text" name="nome" placeholder="Nome" id="input-nome" required></p>
                <p><input type="text" name="email" placeholder="Email" id="input-email" required></p>
                <p><input type="password" name="senha" placeholder="Senha" id="input-senha" minlength="8" maxlength="16" required></p>
                <p>Cargo</p>
                <select name="cargo">
                    <option value="admin">Administrador</option>
                    <option value="financeiro">Financeiro</option>
                    <option value="estoquista">Estoquista</option>
                </select>
                <p><input type="submit" value="Adicionar"></p>
            </form>
            <form action='index.php' method='post'><input type='submit' value='voltar'></form>

            <script>
                function validarEmail(email) {
                    let re = /\S+@\S+\.\S+/;
                    return re.test(email);
                }

                function validarSenha(senha) {
                    const temMaiuscula = /[A-Z]/.test(senha);
                    const temMinuscula = /[a-z]/.test(senha);
                    const temNumero = /\d/.test(senha);

                    if (temMaiuscula && temMinuscula && temNumero) {
                        return true;
                    } else {
                        return false;
                    }
                }

                function verificarDados() {
                    let email = document.getElementById("input-email").value;
                    let nome = document.getElementById("input-nome").value;
                    let senha = document.getElementById("input-senha").value;

                    if (!validarEmail(email)) {
                        confirm("Digite um email válido!");

                        document.getElementById("input-email").focus();
                        window.onsubmit = function() {
                            return false;
                        };
                    } else if (!validarSenha(senha)) {
                        confirm("A senha deve conter pelo menos uma letra maiúscula, uma letra minúscula e um número!");

                        document.getElementById("input-senha").focus();
                        window.onsubmit = function() {
                            return false;
                        };
                    } else if (nome.length < 3) {
                        confirm("O nome deve ter no mínimo 3 caracteres!");

                        document.getElementById("input-nome").focus();
                        window.onsubmit = function() {
                            return false;
                        };
                    } else if (senha.length < 8) {
                        confirm("A senha deve ter no mínimo 8 caracteres!");

                        document.getElementById("input-senha").focus();
                        window.onsubmit = function() {
                            return false;
                        };
                    } else if (ativo.length > 1 && ativo.length <= 0) {
                        confirm("O status de ativo deve ser somente 's' (sim) ou 'n' (não)");

                        document.getElementById("input-ativo").focus();
                        window.onsubmit = function() {
                            return false;
                        };
                    } else {
                        return true;
                    }
                }
            </script>

        </center>
    <?php
    if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['cargo'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $cargo = $_POST['cargo'];

        $func = new admFunc();
        $func->cadastrar($nome, $email, $senha, $cargo);
    }
}
    ?>
    </body>

    </html>