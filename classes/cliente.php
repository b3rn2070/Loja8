<?php 
    require_once 'conexao.php';

    class Cliente {
        private $conn;
        private $nome;
        private $email;
        private $senha;
        private $id;

        function __construct($id){
            $this->conn = new Conexao("localhost", "root", "", "loja8");
            $this->conn->conectar();

            $this->id = $id;
            $this->getInfo($id);
        }

        function getInfo($id){
            $sql = "SELECT * FROM `tbclientes` WHERE `idCli` = '$id';";
            $resultado = $this->conn->execQuery($sql);

            if($linha = mysqli_fetch_array($resultado)){
                $this->nome = $linha["nomeCli"];
                $this->email = $linha["emailCli"];
                $this->senha = $linha["senhaCli"];
                $this->id = $linha["idCli"];
            }
        }

        function alterarConta($nome, $email, $senha){
            $sql = "UPDATE `tbclientes` SET `nomeCli` = ?, `emailCli` = ?, `senhaCli` = ? WHERE `idCli` = ?";
            $stmt = $this->conn->getConn()->prepare($sql);
            $stmt->bind_param("sssi", $nome, $email, $senha, $this->id);
            $stmt->execute();
            $stmt->close();
        }

        function verificarEmail($email){
            $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
            if(preg_match($pattern, $email) == 1) {
                return true;
            } else {
                return false;
            }
        }

        function getNome(){
            return $this->nome;
        }

        function getEmail(){
            return $this->email;
        }

        function getSenha(){
            return $this->senha;
        }
    }
?>