<?php
session_start();
require_once 'classes/conexao.php';

$conn = new Conexao("localhost", "root", "", "loja8");
$conn->conectar();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja 8</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
<nav class="navbar">
        <div class="logo">
            <h1>Loja 8</h1>
        </div>
        <ul class="nav-links">
            <?php 
                if((!isset($_SESSION['logado'])) || ($_SESSION['logado'] == 0)){
                    ?>
                        <li><a href="login.php">Login</a></li>
                    <?php
                }
            
                if((isset($_SESSION['logado'])) && ($_SESSION['logado'] == 1) ){
                    ?> 
                        <li><a href="alterarConta.php">Alterar Conta</a></li>
                        <li><a href="sair.php">Logout</a></li>
                    <?php
                }
        ?>
        </ul>
        <div class="cart">
            <a href="carrinho.php"><img src="cart-icon.png" alt="Carrinho de Compras"></a>
        </div>
    </nav>
    <div>
       
        <?php
        // produtos em promocao

        $sql = "SELECT * FROM `tbproduto` WHERE `ativo` = 1 AND `promocao` = 1 AND `qnt` > 0";
        $resultado = $conn->execQuery($sql);

        if ($resultado) {
            while ($linha = mysqli_fetch_array($resultado)) {
                echo "<a href=\"mostrarProduto.php?idProd=" . $linha["idProd"] . "\"><img width='50%' src='images/" . $linha["fotoProd"] . "'></a>";
            }
        }

        ?>
    </div>
    <div>
        <?php
        // produtos sem promoçao 
        $sql = "SELECT * FROM `tbproduto` WHERE `ativo` = 1 AND `promocao` = 0 AND `qnt` > 0;";
        $resultado = $conn->execQuery($sql);
        while ($linha = mysqli_fetch_array($resultado)) {
            echo "<a href=\"mostrarProduto.php?idProd=" . $linha["idProd"] . "\"><img width='50%' src='images/" . $linha["fotoProd"] . "'></a>";
        }
        $conn->desconectar();
        ?>
    </div>
        <footer>
            <p>Feito por tarãrã</p>
        </footer>
</body>
</html>

