<?php

// Inclusão
include 'calculadora.class.php';

// Instanciando objeto e recebendo valores via construtor
$calc = new Calculadora(10,2);

echo '<br>Soma: ' . $calc -> somar().
    '<br>Subtração: ' . $calc -> subtrair().
    '<br>Multiplicação: ' . $calc -> multiplicar().
    '<br>Divisão: ' . $calc -> dividir(); 

?>
