<?php 
    require_once 'conexao.php';
    
    class Login {
        private $conn;
        private $email;
        private $senha;
        private $nome;
        private $id;
        private $logado;

        function __construct($email, $senha){
            $this->conn = new Conexao("localhost", "root", "", "loja8");
            $this->conn->conectar();

            $this->email = $email;
            $this->senha = $senha;
            $this->logado = 0;
        }

        function logar(){
            $sql = "SELECT * FROM `tbclientes` WHERE `emailCli` = ?";
            $stmt = $this->conn->getConn()->prepare($sql);
            $stmt->bind_param("s", $this->email);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if($linha = mysqli_fetch_array($resultado)) {
                if(password_verify($this->senha, $linha['senhaCli'])){
                    $this->nome = $linha["nomeCli"];
                    $this->id = $linha["idCli"];
    
                    $_SESSION["logado"] = 1;
                    $_SESSION['idCliente'] = $linha['idCli'];    
                    header("Location: index.php");
                    return true;
                } else {
                    return false;
                }
            } 
        }

        
    }
?>