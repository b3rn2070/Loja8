<?php
require_once '../../classes/conexao.php';
require_once '../../classes/admProd.php';
session_start();

if (!isset($_SESSION['logadoAdm']) || $_SESSION['logadoAdm'] == 0) { ?>
    <script>
        const usrResp = confirm("você precisa fazer login");

        if (usrResp) {
            window.location.href = "../login.php";
        }
    </script>

<?php } else if ($_SESSION['cargo'] == 'financeiro') {
    header("Location: ../admin/index.php");
} else {
?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Produto</title>
    </head>

    <body>
        <center>
            <form action="add.php" method="post" onsubmit="validarImagem()" enctype="multipart/form-data">
                <p>Nome:<input type='text' name="nomeProd" value="" required></p>
                <p>Descrição:<input type='text' name="descProd" value="" required></p>
                <p>Preço de Venda:<input type='text' name="precoVenda" value="" required></p>
                <p>Preço promocional:<input type='text' name="precoProm" value="" id="promo"></p>
                <p>Quantidade:<input type='text' name="qnt" value="" id="qnt"></p>
                <p>Promoção:
                    <select name="prom">
                        <option value="1"> 1 </option>
                        <option value="0"> 0 </option>
                    </select>
                </p>
                <p>Ativo:
                    <select name="ativo">
                        <option value="1"> 1 </option>
                        <option value="0"> 0 </option>
                    </select>
                </p>
                <p>Imagem do Produto: <input type="file" name="fotoProd" id="img" required></p>
                <img width="300" src="" id="preview">
                <p></p>
                <p><input type="submit" value="Adicionar"></p>
            </form>
            <form action="index.php" method="post"><input type="submit" value="voltar"></form>

            <script>
                function validarImagem() {
                    const input = document.getElementById('img');
                    const promo = document.getElementById('promo');
                    const filePath = input.value;
                    const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

                    if (!allowedExtensions.exec(filePath)) {
                        alert('Envie um arquivo de imagem válido (JPG, JPEG, PNG, GIF).');
                        input.value = '';
                        return false;
                    }

                    const file = input.files[0];
                    const fileType = file['type'];
                    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];

                    if (!validImageTypes.includes(fileType)) {
                        alert('Por favor, envie um arquivo de imagem válido (JPG, JPEG, PNG, GIF).');
                        input.value = '';
                        return false;
                    }

                    return true;
                }

                document.getElementById("img").onchange = function() {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        document.getElementById("preview").src = e.target.result;
                    };

                    reader.readAsDataURL(this.files[0]);
                };

                if (!promo) {
                    promo = 0;
                }

                <?php } ?>
            </script>
        </center>
        <?php 
            if(isset($_POST['nomeProd']) && isset($_POST['descProd']) && isset($_POST['precoVenda']) && isset($_POST['precoProm']) && isset($_POST['qnt']) && isset($_POST['prom']) && isset($_POST['ativo']) && isset($_FILES['fotoProd'])){
                $nomeProd = $_POST['nomeProd'];
                $descProd = $_POST['descProd'];
                $precoVenda = $_POST['precoVenda'];
                $precoProm = $_POST['precoProm'];
                $qnt = $_POST['qnt'];
                $prom = $_POST['prom'];
                $ativo = $_POST['ativo'];
                $imagem = $_FILES['fotoProd'];

                $admProd = new AdmProd();
                $admProd->addProd($nomeProd, $descProd, $imagem, $qnt, $precoVenda, $precoProm, $prom, $ativo);
            }
        ?>
    </body>
    </html>