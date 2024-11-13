
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
    require_once '../../classes/admProd.php';

    if(!isset($_SESSION['logadoAdm']) || $_SESSION['logadoAdm'] == 0) { ?>
        <script>
        const usrResp = confirm("você precisa fazer login");
        if(usrResp){
            window.location.href = "../index.php";
        }
        </script>
    <?php } else if($_SESSION['cargo'] == 'financeiro') {
        echo "<script>
                const usrResp3 = confirm('Você não tem permissão para acessar essa página!');
                if(usrResp3){
                    window.location.href = '../index.php';
                }
            </script>";
            } else { 
                $idProd = 0;
                if(isset($_GET['idProd']) && isset($_GET['nomeProd']) && isset($_GET['descr']) && isset($_GET['precoVenda']) && isset($_GET['precoProm']) && isset($_GET['promocao']) && isset($_GET['ativo'])){
                    $idProd = $_GET['idProd']; 
                    echo "Informações Atuais<br>";
                    echo "Nome: ".$_GET['nomeProd']."<br>";
                    echo "Descrição: ".$_GET['descr']."<br>";
                    echo "Quantidade: ".$_GET['qnt']."<br>";
                    echo "Preço de Venda: ".$_GET['precoVenda']."<br>";
                    echo "Preço promocional: ".$_GET['precoProm']."<br>";
                    echo "Promoção: ".$_GET['promocao']."<br>";
                    echo "Ativo: ".$_GET['ativo']."<br>";
                    echo "Altere as informações abaixo:<br>";
                }
            ?>
            <form action="" method="post">
                <input type="hidden" name="idProd" value="<?php echo $idProd ?>"> 
                <p>Nome:<input type='text' name="nomeNovo"  value="<?php if(isset($_GET['nomeProd'])) {echo $_GET['nomeProd'];} ?>" required></p>
                <p>Descrição:<input type='text' name="descNovo" value="<?php if(isset($_GET['descr'])) {echo $_GET['descr'];} ?>"  required></p>
                <p>Quantidade:<input type='text' name="qntNovo" value="<?php if(isset($_GET['qnt'])) {echo $_GET['qnt'];} ?>"  required></p>
                <p>Preço de Venda:<input type='text' name="pvNovo"  value="<?php if(isset($_GET['precoVenda'])) {echo $_GET['precoVenda'];} ?>" required></p>
                <p>Preço promocional:<input type='text' name="ppNovo"  value="<?php if(isset($_GET['precoProm'])) {echo $_GET['precoProm'];} ?>" required></p>
                <p>Promoção:
                <select name="promoNovo">
                    <option value="1" <?php if(isset($_GET['promocao']) && $_GET['promocao'] == 1){echo 'selected';}?> >Sim</option>
                    <option value='0' <?php if(isset($_GET['promocao']) && $_GET['promocao'] == 0){echo 'selected';}?> >Não</option>
                </select></p>
                <p>Ativo:
                <select name="ativoNovo">
                    <option value="1" <?php if(isset($_GET['ativo']) && $_GET['ativo'] == 1){echo 'selected';}?> >Sim</option>
                    <option value="0" <?php if(isset($_GET['ativo']) && $_GET['ativo'] == 0){echo 'selected';}?> >Não</option>
                </select></p>
                <p><input type="submit" value="Alterar"></p>
            </form>
            <form action='index.php' method='post'><input type='submit' value='voltar'></form>

       <?php 
        if(isset($_REQUEST['idProd']) && isset($_REQUEST['nomeNovo']) && isset($_REQUEST['qntNovo']) && isset($_REQUEST['descNovo']) && isset($_REQUEST['pvNovo']) && isset($_REQUEST['ppNovo']) && isset($_REQUEST['promoNovo']) && isset($_REQUEST['ativoNovo'])){
            $adm = new AdmProd();
            $resultado = $adm->atualizarProd($idProd, $_REQUEST['nomeNovo'], $_REQUEST['descNovo'], $_REQUEST['qntNovo'], $_REQUEST['pvNovo'], $_REQUEST['ppNovo'], $_REQUEST['promoNovo'], $_REQUEST['ativoNovo']);
            
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