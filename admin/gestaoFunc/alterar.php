
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
<?php 
    session_start();
    require_once '../../classes/admFunc.php';

    if(!isset($_SESSION['logadoAdm']) || $_SESSION['logadoAdm'] == 0) { ?>
        <script>
        const usrResp = confirm("você precisa fazer login");
        if(usrResp){
            window.location.href = "../index.php";
        }
        </script>
    <?php } else if($_SESSION['cargo'] == 'estoquista' || $_SESSION['cargo'] == 'financeiro') {
        echo "<script>
                const usrResp3 = confirm('Você não tem permissão para acessar essa página!');
                if(usrResp3){
                    window.location.href = '../index.php';
                }
            </script>";
     } else { 
            if(isset($_REQUEST['idFunc'])){
                $idFunc = $_REQUEST['idFunc']; 
                echo "Informações Atuais<br>";
                echo "Nome: ".$_REQUEST['nomeFunc']."<br>";
                echo "Email: ".$_REQUEST['emailFunc']."<br>";
                echo "Função: ".$_REQUEST['cargo']."<br>";
                echo "Ativo: ".$_REQUEST['ativo']."<br>";
                echo "Altere as informações abaixo:<br>";
            }
        ?>
        <form action="" method="post" onsubmit="verificarDados()">
            <input type = "hidden" name="idFunc" value="<?php echo $idFunc;?>">
            <p>Nome:<input type='text' name="nomeNovo" placeholder="Nome"  value="<?php if(isset($_REQUEST['nomeFunc'])) {echo $_REQUEST['nomeFunc'];} ?>" id="input-email" required></p>
            <p>Email:<input type='text' name="emailNovo" placeholder='Email' value="<?php if(isset($_REQUEST['emailFunc'])) {echo $_REQUEST['emailFunc'];} ?>" id="input-email" required></p>
            <p>Senha:<input type='text' name="senhaNovo" placeholder='Senha' minlength="8" maxlength="16" id="input-senha"required></p>
            <p>Cargo:
            <select name="cargoNovo" >
                <option value="admin" <?php if(isset($_REQUEST['cargo']) && $_REQUEST['cargo'] == 'admin'){echo 'selected';}?> >Administrador</option>
                <option value="caixa" <?php if(isset($_REQUEST['cargo']) && $_REQUEST['cargo'] == 'caixa'){echo 'selected';}?> >Caixa</option>
                <option value="vendedor" <?php if(isset($_REQUEST['cargo']) && $_REQUEST['cargo'] == 'vendedor'){echo 'selected';}?> >Vendedor</option>
            </select></p>
            <p>Ativo:
            <select name="ativoNovo" >
                <option value="1" <?php if(isset($_REQUEST['ativo']) && $_REQUEST['ativo'] == 1){echo 'selected';}?> >1</option>
                <option value="0" <?php if(isset($_REQUEST['ativo']) && $_REQUEST['ativo'] == 0){echo 'selected';}?> >0</option>
            </select></p>
            <input type="submit" value="Alterar">
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
                    }
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

       <?php 
        if(isset($_REQUEST['nomeNovo']) && isset($_REQUEST['emailNovo']) && isset($_REQUEST['senhaNovo']) && isset($_REQUEST['cargoNovo']) && isset($_REQUEST['ativoNovo'])){
            $id = $_REQUEST['idFunc'];
            $nome = $_REQUEST['nomeNovo'];
            $email = $_REQUEST['emailNovo'];
            $senha = $_REQUEST['senhaNovo'];
            $senha = password_hash($senha, PASSWORD_BCRYPT);
            $cargo = $_REQUEST['cargoNovo'];
            $ativo = $_REQUEST['ativoNovo'];
            $idFunc = $_REQUEST['idFunc'];

            $admFunc = new AdmFunc();
            $resultado = $admFunc->atualizarFunc($id, $nome, $email, $senha, $ativo, $cargo);

            if($resultado == true){
                ?> <script>
                        const usrResp2 = confirm('Alteração realizada com sucesso!');
                        if(usrResp2){
                            window.location.href = 'index.php';
                        }
                    </script> <?php
            } else {
                echo "<script>confirm('Erro ao alterar!');</script>";
            }
        }
}
       ?>
</body>
</html>