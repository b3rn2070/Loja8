<?php
require 'conexao.php';

class Carrinho
{
    private $produtos;
    private $conn;

    function __construct()
    {
        $this->conn = new Conexao("localhost", "root", "", "loja8");
        $this->conn->conectar();

        if (isset($_SESSION['carrinho'])) {
            $this->produtos = $_SESSION['carrinho'];
        } else {
            $this->produtos = [];
        }
    }

    private function save()
    {
        $_SESSION["carrinho"] = $this->produtos;
    }

    function addProduto($id)
    {
        if (!isset($this->produtos[$id])) {
            $this->produtos[$id] = 1;
        } else {
            $this->produtos[$id] += 1;
        }
        $this->save();
    }

    function getQnt($id)
    {
        return $this->produtos[$id];
    }

    function removeProduto($id)
    {
        if (isset($this->produtos[$id])) {
            $this->produtos[$id] -= 1;

            if ($this->produtos[$id] <= 0) {
                unset($this->produtos[$id]);
            }
        }
        $this->save();
    }


    function limparCarrinho()
{
    $this->produtos = array();
    $this->save();
}

    function comprar()
    {
        $preco = 0;
        $idCliente = $_SESSION["idCliente"];

        foreach ($this->produtos as $idProduto => $qnt) {
            $sql = "SELECT * FROM tbProduto WHERE `idProd`= '$idProduto'";
            $resultado = $this->conn->execQuery($sql);

            while ($linha = mysqli_fetch_array($resultado)) {
                $qntEstoque = $linha["qnt"];

                if ($linha["promocao"] == 1) {
                    $preco = $linha["precoProm"];
                } else {
                    $preco = $linha["precoVenda"];
                }

                if($qnt > $qntEstoque){
                    echo "<script>confirm('Quantidade insuficiente do produto: ".$linha["nomeProd"]." (Em estoque: ". $qntEstoque ." unidades)');</script>";
                    return;
                }

                $sql2 = "INSERT INTO `tbpedidos`(`idPedido`, `idProduto`, `idCli`, `data`, `precoVenda`, `qnt`) VALUES (NULL, '$idProduto', '$idCliente', current_timestamp(),'$preco','$qnt');";
                $sql3 = "UPDATE `tbproduto` SET `qnt`= `qnt` - $qnt WHERE `idProd` = '$idProduto';";
                $resultadoCompra = $this->conn->execQuery($sql2);
                $atualizarEstoque = $this->conn->execQuery($sql3);
            }
        }
        if ($resultadoCompra && $atualizarEstoque) {
            return true;
        } else {
            return false;
        }
        
    }

    function listarCarrinho()
    {

        if (empty($this->produtos)) {
            echo "<h1>Carrinho vazio</h1>";
        } else {
            echo "<table align='center' border='1'>";
            echo "<thead align='center'>";
            echo "<tr>";
            echo "<th> </th>";
            echo "<th> Nome </th>";
            echo "<th> Quantidade </th>";
            echo "<th> Preço </th>";
            echo "<th> Subtotal </th>";
            echo "<th> Adicionar </th>";
            echo "<th> Remover </th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody align='center  '>";
        
            $total = 0;

            foreach ($this->produtos as $id => $qnt) {
                $sql = "SELECT * FROM `tbproduto` WHERE `idProd` = '$id';";
                $resultado = $this->conn->execQuery($sql);

                while ($linha = mysqli_fetch_array($resultado)) {
                    echo "<tr>";
                    echo "<td> <img width='40%' src='images/" . $linha['fotoProd'] . "'> </td>";
                    echo "<td> " . $linha['nomeProd'] . " </td>";
                    echo "<td> " . $qnt . " </td>";
                    if ($linha['promocao'] == 1) {
                        $subTotal = $qnt * $linha['precoProm'];
                        $total += $qnt * $linha['precoProm'];

                        echo "<td>R$" . $linha['precoProm'] . "</td>";
                        echo "<td>R$" . $subTotal . "</td>";
                    } else {
                        $subTotal = $qnt * $linha['precoVenda'];
                        $total += $qnt * $linha['precoVenda'];

                        echo "<td>R$" . $linha['precoVenda'] . "</td>";
                        echo "<td>R$" . $subTotal . "</td>";
                    }
                    echo "<td> <form action='?acao=add&idProd=$id' method='post'><input type='submit' value='adicionar 1'></form> </td>";
                    echo "<td> <form action='?acao=remover&idProd=$id' method='post'><input type='submit' value='remover 1'></form> </td>";
                    echo "</tr>";
                }
            }

            echo "</tbody>";
            echo "<tfoot> <tr> <td> Total: R$$total <td colspan='6' style='text-align: right;'> <form action='?acao=comprar' method='post'><input type='submit' value='comprar'></form> </td> </td> </tr> </tfoot>";
            echo "</table>";
        }
    }
}
