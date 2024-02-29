<?php

        $dbHost = 'localhost';
        $dbUsername = 'root';
        $dbPassword = '';
        $dbName = 'cadatro-test';

    $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($conexao->connect_errno) {
        echo "erro";
    }
    else{
        echo "Conexão efetuada com sucesso";
    }
?>