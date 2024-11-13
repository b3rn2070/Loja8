<?php     
    class Produto {
        private $id;
        private $nome;
        private $descr;
        private $precoVenda;
        private $promocao;
        private $precoProm;
        private $ativo;

        function __construct($id, $nome, $descr, $precoVenda, $promocao, $precoProm, $ativo){
            $this->id = $id;
            $this->nome = $nome;
            $this->descr = $descr;
            $this->precoVenda = $precoVenda;
            $this->promocao = $promocao;
            $this->precoProm = $precoProm;
            $this->ativo = $ativo;
        }

        function getId(){
            return $this->id;
        }

        function getNome(){
            return $this->nome;
        }

        function getDescr(){
            return $this->descr;
        }

        function getPrecoVenda(){
            return $this->precoVenda;
        }

        function getPromocao(){
            return $this->promocao;
        }   

        function getPrecoProm(){
            return $this->precoProm;
        }

        function getAtivo(){
            return $this->ativo;
        }

        function setId($id){
            $this->id = $id;
        }

        function setNome($nome){
            $this->nome = $nome;
        }

        function setDescr($descr){
            $this->descr = $descr;
        }

        function setPrecoVenda($precoVenda){
            $this->precoVenda = $precoVenda;
        }

        function setPromocao($promocao){
            $this->promocao = $promocao;
        }

        function setPrecoProm($precoProm){
            $this->precoProm = $precoProm;
        }

        function setAtivo($ativo){
            $this->ativo = $ativo;
        }
    }
?>