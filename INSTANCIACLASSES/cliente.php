<?php

class Cliente {
    // Atributos de classe
    private $idCliente;
    private $nome;
    private $rg;

    // Construtor da Classe Cliente
    public function Cliente  (){

    }

    //Métodos Acessores
    public function getIdCliente(){
        return $this->idCliente;
    }

    public function setIdCliente($idCliente){
        $this->idCliente = $idCliente;
    }


    public function getNome(){
        return $this ->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }


    public function getRg(){
        return $this ->rg;
    }

    public function setRg($rg){
        $this->rg = $rg;
    }


}// fecha a classe Cliente

?>