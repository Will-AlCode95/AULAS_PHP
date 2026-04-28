<?php
// Inclusão da classe

include 'calculadora.class.php';


// Instanciar o objeto
$calc = new Calculadora();

//Recebendo valores de forma fixa 
$calc -> setNum1(8);
$calc -> setNum2(2);

// Imprimindo resultados
echo '<br>Soma: ' . $calc -> somar().
    '<br>Subtração: ' . $calc -> subtrair().
    '<br>Multiplicação: ' . $calc -> multiplicar().
    '<br>Divisão: ' . $calc -> dividir(); 

?>