<?php
require_once 'conexao.php';

class AdmFunc
{
    private $conn;

    function __construct()
    {
        $this->conn = new Conexao("localhost", "root", "", "loja8");
        $this->conn->conectar();
    }

    function logar($email, $senha)
    {
        $sql = "SELECT * FROM `tbfuncionarios` WHERE `emailFunc` = ? AND `ativo` = 1";
        $stmt = $this->conn->getConn()->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($linha = mysqli_fetch_array($resultado)) {
            if (password_verify($senha, $linha['senhaFunc'])) {
                $_SESSION["logadoAdm"] = 1;
                $_SESSION['idFunc'] = $linha['idFunc'];
                $_SESSION['cargo'] = $linha['cargo'];

                return true;
                header("Location: index.php");
            } else {
                return false;
            }
        }
    }

    function cadastrar($nome, $email, $senha, $cargo)
    {
        $sql = "INSERT INTO `tbfuncionarios`(`idFunc`, `nomeFunc`, `emailFunc`, `senhaFunc`, `ativo`, `cargo`) 
                VALUES (NULL, ?, ?, ?, 1, ?)";
        $stmt = $this->conn->getConn()->prepare($sql);
        $stmt->bind_param("ssss", $nome, $email, $senha, $cargo);
        $stmt->execute();
        $stmt->close();
        exit;
    }

    function listarFunc()
    {
        echo "<table align='center' border='1'>";
        echo "<thead align='center'>";
        echo "<tr>";
        echo "<th> Id </th>";
        echo "<th> Nome </th>";
        echo "<th> Email </th>";
        echo "<th> Cargo </th>";
        echo "<th> Ativo </th>";
        echo "<th> Remover </th>";
        echo "<th> Alterar </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody align='center'>";

        $sql = "SELECT * FROM `tbfuncionarios`;";
        $resultado = $this->conn->execQuery($sql);

        while ($linha = mysqli_fetch_array($resultado)) {
            $idFunc = $linha['idFunc'];
            $dados = "idFunc=" . $idFunc . "&nomeFunc=" . $linha['nomeFunc'] . "&emailFunc=" . $linha['emailFunc'] . "&cargo=" . $linha['cargo'] . "&ativo=" . $linha['ativo'];

            echo "<tr>";
            echo "<th>" . $idFunc . "</th>";
            echo "<th>" . $linha['nomeFunc'] . "</th>";
            echo "<th>" . $linha['emailFunc'] . "</th>";
            echo "<th>" . $linha['cargo'] . "</th>";
            echo "<th>" . $linha['ativo'] . "</th>";
            echo "<th><form action='?$dados&acao=remover' method='post'> <input type='submit' name='remover' value='Remover'></form></th>";
            echo "<th><form action='alterar.php?$dados&acao=alterar' method='post'> <input type='submit' name='alterar' value='Alterar'></form></th>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }

    function removerFunc($id)
    {
        $sql = "DELETE FROM `tbfuncionarios` WHERE `idFunc` = $id;";
        $this->conn->execQuery($sql);
    }

    function atualizarFunc($id, $nome, $email, $senha, $ativo, $cargo)
    {
        $sql = "UPDATE `tbfuncionarios` SET `nomeFunc`='$nome',`emailFunc`='$email',`senhaFunc`='$senha',`ativo`=$ativo,`cargo`='$cargo' WHERE `idFunc` =  $id;";
        $resultado = $this->conn->execQuery($sql);

        if ($resultado == true) {
            return true;
        } else {
            return false;
        }
    }
}
