<?php
    //Comentário de linha
    /*
        Instruções devem terminar com ponto e vírgula;

        Todo arquivo contendo PHP deve terminal com a extensão .php;

        * Variáveis *
        -> devem começar com $
        -> exemplo: $nome, $idade
        -> criadas automaticamente na primeira atribuição

        * Regras de nomenclatura
            - iniciar com letra ou _
            - Não pode conter espaços
            - conter apenas caracters alfanumericos 
        -> strings são definidas com aspas $nome = "joão";

        //exibição de dados

        echo  ->  mais comum e rápido. Imprime texto/HTML
        print  -> funciona igual ao echo
        printf -> permite formatação avançada

    
    */

?>

<?php 
    echo "<p>texto gerado pelo PHP</p>";
    $nome = "adamastor";
    echo "<p>bem vindo $nome</p>";

    $valor = 10;
    $formato = "R$%.2f";
    printf($formato, $valor);
    print "  <br>  ";

    /* OPERADORES ARITMÉTICOS */

    // Adição (+)

    $x=2;
    echo $x + 2  .  "<br>";
    print $x + 22;

    // Subtração  ( - )

    'echo 5 - $x . "<br>";'
 
    // Multiplicação
    
    $x=4;
    echo $x * 4 . "<br>";

    // Divisão
    $x = 15;
    echo $x / 3 . "<br>";

    // Módulo (resto)
    echo 5 % 2 . "<br>";

    // Incremento

    $x=8;
    $x++ ;
    echo $x++ . "<br>";

    $x--;
    echo $x . "<br>";

    /* OPERADORES DE COMPARAÇÃO  */

    //atribuição simples ( = )
    $x = 10;
    echo $x  .  "<br>";

    // Atribuição e adição ( += )
    $x = 10;
    $y = 5;
    $x += $y;  // equivale a : $x  =  $x  +  $y
    echo $x  .  "<br>";

    $x = 8;
    $y = 3;
    $x -= $y;
    echo $x . "<br>";

    // atribuição e multiplicação (*=)
    $x = 10;
    $y = 2;
    $x *= $y;
    echo $x . "<br>";

    //atribuiçãp e divisão ( /= )
    $x /= $y;
    echo $x  . "<br>";

    // Atribuição e Módulo ( %= )
    $x = 10;
    $y = 3;
    $x %= $y;
    echo $x . "<br>";

    // atribuição e concatenação (.=)

    $texto = "Olá";
    $sufixo = "Mundo!";
    $texto .= $sufixo;
    echo $texto  .  "<br>";

?>

