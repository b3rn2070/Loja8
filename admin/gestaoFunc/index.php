<?php
require_once '../../classes/conexao.php';
require_once '../../classes/admFunc.php';
$adm = new AdmFunc();
session_start();

if (!isset($_SESSION['logadoAdm']) || $_SESSION['logadoAdm'] == 0) { ?>
     <script>
         const usrResp = confirm("você precisa fazer login");

         if (usrResp) {
             window.location.href = "../login.php";
         }
    </script>

<?php } else if($_SESSION['cargo'] == 'financeiro' || $_SESSION['cargo'] == 'estoquista') {
    header("Location: ../index.php");
} else {
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão Funcionário</title>
</head>
<body>
<center>
    <form action="add.php" method="post">
        <input type="submit" value="Adicionar Funcionário">
    </form>

    <?php
        if(isset($_REQUEST['acao'])){
            $acao = $_REQUEST['acao'];

            if($acao == 'remover'){
                $adm->removerFunc($_REQUEST['idFunc']);
            }
        }
    
        $adm->listarFunc();
    ?>
    
    <form action="../index.php" method="post"><input type="submit" value="voltar"></form>
</center>
<?php } ?>
</body>
</html>