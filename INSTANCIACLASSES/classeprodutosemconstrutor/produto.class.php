<?php
    class NomeDaClasse {
    // Atributos
        private $nome;
        private $valor;
    }

    public function setNome($nome, $valor) {
        $this -> nome = $nome;
        $this -> valor = $valor;
        // guardar esse valor dentro do objeto
    }