<?php
include_once 'cliente.php';

/* Inclusão de classe - sugiro sempre utilizar no início do código antes de instanciar um objeto

include() - "WARNING"
require() - "FATAL ERROR"
include_once()
require_once()

*/



// Instanciando a class_exists
$cli = new Cliente;

// Recebendo valores através dos métodos sets() /de forma fixa
$cli -> setIdCliente(1);
$cli ->setNome('William');
$cli ->setRg('1033965227');

// exibição com 3 echos
echo'<p>Código do Cliente: ' . $cli -> getIdCliente() . '<br>';
echo 'Nome: ' . $cli ->getNome() . '<br>';
echo'RG: ' . $cli ->getRg() . '</p>';

// Exibição com apenas um echo
echo'<p>Código do Cliente: ' . $cli ->getIdCliente(). '<br>' .
    'Nome: ' . $cli -> getNome() . '<br>' .
    'RG: ' . $cli -> getRg() . '</p>';
    
?>