<?php
require_once '../../classes/conexao.php';
require_once '../../classes/admProd.php';
$adm = new AdmProd();
session_start();

if (!isset($_SESSION['logadoAdm']) || $_SESSION['logadoAdm'] == 0) { ?>
     <script>
         const usrResp = confirm("você precisa fazer login");

         if (usrResp) {
             window.location.href = "../admin/login.php";
         }
    </script>

<?php } else if($_SESSION['cargo'] == 'financeiro') {
    header("Location: ../index.php");
} else {
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Estoque</title>
</head>
<body>
<center>
    <form action="add.php" method="post">
        <input type="submit" value="Adicionar Produto">
    </form>

    <?php
        if(isset($_REQUEST['acao'])){
            $acao = $_REQUEST['acao'];

            if($acao == 'remover'){
                $adm->removerProd($_REQUEST['idProd']);
            }
        }
    
        $adm->listarProd();
    ?>
    
    <form action="../index.php" method="post"><input type="submit" value="voltar"></form>
</center>
<?php } ?>
</body>
</html>