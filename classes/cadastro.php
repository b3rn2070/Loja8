<?php 
    require_once 'conexao.php';

    class Cadastro {
        private $conn;
        private $nome;
        private $email;
        private $senha;
        private $cpf;

        function __construct($nome, $email, $senha, $cpf){
            $this->conn = new Conexao("localhost", "root", "", "loja8");
            $this->conn->conectar();

            $this->nome = $nome;
            $this->email = $email;
            $this->senha = $senha;
            $this->cpf = $cpf;
        }

        function cadastrar(){
            $sql = "INSERT INTO `tbclientes`(`idCli`, `nomeCli`, `emailCli`, `senhaCli`, `cpf`) VALUES (NULL, ?, ?, ?, ?)";
            $stmt = $this->conn->getConn()->prepare($sql);
            $stmt->bind_param("ssss", $this->nome, $this->email, $this->senha, $this->cpf);
            $stmt->execute();
            $stmt->close();
            return true;
        }

        function verificarEmail(){
            $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
            if(preg_match($pattern, $this->email) == 1) {
                return true;
            } else {
                return false;
            }
        }

        function verificarCpfBD(){
            $sql = "SELECT * FROM `tbclientes` WHERE cpf = ?";
            $stmt = $this->conn->getConn()->prepare($sql);
            $stmt->bind_param("s", $this->cpf);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $stmt->close();
    
            return $resultado->num_rows > 0;
        }
    }
?>