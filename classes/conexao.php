<?php 
    class Conexao {
        private $host;
        private $usr;
        private $bd;
        private $pass;
        private $conn;

        function __construct($host, $usr, $pass, $bd){
            
            $this->host = $host;
            $this->usr = $usr;
            $this->pass = $pass;
            $this->bd = $bd;
        }

        function conectar()
        {
            $this->conn = mysqli_connect($this->host, $this->usr, $this->pass, $this->bd);

            if (mysqli_connect_errno()) {
                echo "Falha na conexão com o MySQL: " . mysqli_connect_error();
                return false;
            }
    
            mysqli_set_charset($this->conn, 'utf8');
            return true;
        }

        function execQuery($sql){
            return mysqli_query($this->conn, $sql);
        }

        function desconectar(){
            return mysqli_close($this->conn);
        }

        function getConn(){
            return $this->conn;
        }


    }
?>