<?php
session_start();
if (!isset($_SESSION["logadoAdm"]) || ($_SESSION["logadoAdm"] == 0)) {
    header("Location: login.php");
} ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <form action="relatorioVendas.php" method="post"><input type="submit" value="Relatório de Vendas"></form>
    <?php 
        if($_SESSION['cargo'] == 'admin'){
            ?> <form action="gestaoFunc/index.php" method="post"><input type="submit" value="Gestão de Funcionários"></form> <?php
        }
    ?>
    <?php 
        if($_SESSION['cargo'] == 'admin'){
            ?> <form action="gestaoProd/index.php" method="post"><input type="submit" value="Gestão de Estoque"></form> <?php
        }
    ?>
    <form action="../sair.php" method="post"><input type="submit" value="deslogar"></form>
    <form action="../index.php" method="post"><input type="submit" value="voltar"></form>
    
</body>
</html>