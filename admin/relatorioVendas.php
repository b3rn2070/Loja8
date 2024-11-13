<?php
session_start();
require_once '../classes/conexao.php';
require_once '../classes/relatorio.php';
$conn = new Conexao("localhost", "root", "", "loja8");

if (!isset($_SESSION['logadoAdm']) || $_SESSION['logadoAdm'] == 0) { ?>
    <script>
        const usrResp = confirm("você precisa fazer login");

        if (usrResp) {
            window.location.href = "login.php";
        }
    </script>
<?php } else if($_SESSION['cargo'] == 'estoquista') { 
    header("Location: index.php");
} else { ?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Relatorio de Venda</title>
    </head>

    <body>
        <center>

            <h4>Relatório de Vendas</h4>
            <form action="relatorioVendas.php" method="post">
                <input type="date" name="data" required>
                <input type="submit" value="enviar">
            </form>
            <h4>Relatorio do Dia</h4>
            <form action="relatorioVendas.php" method="post">
                <input type="submit" value="Relatorio">
                <input type="hidden" name="diaAtual">
            </form>

            <form action='index.php' method='post'><input type='submit' value='voltar'></form>

    <?php
    date_default_timezone_set('America/Sao_Paulo');
    if (isset($_POST['data'])) {
        $data = $_POST['data'];

        $relatorio = new Relatorio();
        $relatorio->relatorioProd($data);

    } else if (isset($_POST['diaAtual'])) {
        $data = date('Y-m-d', null);
        
        $relatorio = new Relatorio();
        $relatorio->relatorioProd($data);
    }
} ?>
    </center>
</body>
</html>