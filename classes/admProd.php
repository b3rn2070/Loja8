<?php
require_once 'conexao.php';

class AdmProd
{
    private $conn;

    function __construct()
    {
        $this->conn = new Conexao("localhost", "root", "", "loja8");
        $this->conn->conectar();
    }


    function addProd($nome, $descr, $fotoProd, $qnt, $precoVenda, $precoProm, $prom, $ativo)
    {

        $diretorioDestino = '../../images/';
        $fotoProd = $_FILES['fotoProd']['name'];
        $caminhoTemporario = $_FILES['fotoProd']['tmp_name'];
        $caminhoDestino = $diretorioDestino . basename($fotoProd);

        if (isset($_FILES['fotoProd']) && $_FILES['fotoProd']['error'] === UPLOAD_ERR_OK) {

            if (move_uploaded_file($caminhoTemporario, $caminhoDestino)) {
                $sql = "INSERT INTO `tbproduto`(`idProd`, `nomeProd`, `descrProd`, `fotoProd`, `qnt`, `precoVenda`, `promocao`, `precoProm`, `ativo`) 
                        VALUES (NULL, '$nome', '$descr', '$fotoProd', $qnt, $precoVenda, $prom, $precoProm, $ativo)";

                $resultado = $this->conn->execQuery($sql);

                if ($resultado) {
                    echo "<script> confirm('Produto adicionado com sucesso')</script>";
                } else {
                    echo "<script> confirm('Erro ao adicionar o produto')</script>";
                }
            } else {
                echo "Erro ao mover a foto para o servidor.";
            }
        } else {
            echo "Erro no upload da imagem.";
        }
    }

    function listarProd()
    {
        echo "<table align='center' border='1'>";
        echo "<thead align='center'>";
        echo "<tr>";
        echo "<th> Id </th>";
        echo "<th> Foto </th>";
        echo "<th> Nome </th>";
        echo "<th> Descrição </th>";
        echo "<th> Preço </th>";
        echo "<th> Preco Promoção </th>";
        echo "<th> Quantidade </th>";
        echo "<th> Promoção </th>";
        echo "<th> Ativo </th>";
        echo "<th> Remover </th>";
        echo "<th> Alterar </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody align='center'>";

        $sql = "SELECT * FROM `tbproduto`;";
        $resultado = $this->conn->execQuery($sql);

        while ($linha = mysqli_fetch_array($resultado)) {
            $idProd = $linha['idProd'];
            $dados = "idProd=" . $idProd . "&nomeProd=" . $linha['nomeProd'] . "&descr=" . $linha['descrProd'] . "&foto=" . $linha['fotoProd'] . "&qnt=" . $linha['qnt'] . "&promocao=" . $linha['promocao'] . "&precoVenda=" . $linha['precoVenda'] . "&precoProm=" . $linha['precoProm'] . "&ativo=" . $linha['ativo'];

            echo "<tr>";
            echo "<th>" . $idProd . "</th>";
            echo "<th><img width='40%' src='../../images/" . $linha['fotoProd'] . "' alt='Produto'></th>";
            echo "<th>" . $linha['nomeProd'] . "</th>";
            echo "<th>" . $linha['descrProd'] . "</th>";
            echo "<th>" . $linha['precoVenda'] . "</th>";
            echo "<th>" . $linha['precoProm'] . "</th>";
            echo "<th>" . $linha['qnt'] . "</th>";
            echo "<th>" . $linha['promocao'] . "</th>";
            echo "<th>" . $linha['ativo'] . "</th>";
            echo "<th><form action='?$dados&acao=remover' method='post'> <input type='submit' name='remover' value='Remover'></form></th>";
            echo "<th><form action='alterar.php?$dados&acao=alterar' method='post'> <input type='submit' name='alterar' value='Alterar'></form></th>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }

    function removerProd($id)
    {
        $sql = "DELETE FROM `tbproduto` WHERE `idProd` = $id;";
        $this->conn->execQuery($sql);
        unlink("../../images/" . $_REQUEST['foto']);
    }

    function atualizarProd($id, $nome, $descr, $qnt, $precoVenda, $precoProm, $prom, $ativo)
    {
        $sql = "UPDATE `tbproduto` 
                SET `nomeProd`='$nome', `descrProd`='$descr', `qnt`=$qnt, `precoVenda`=$precoVenda, `promocao`=$prom, `precoProm`=$precoProm, `ativo`=$ativo
                WHERE `idProd` =  $id;";

        $resultado = $this->conn->execQuery($sql);
        if ($resultado == true) {
            return true;
        } else {
            return false;
        }
    }
}
