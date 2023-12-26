<?php
ini_set("SMTP", "localhost");
ini_set("smtp_port", "25");
    $host = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "site";

    $con =  new mysqli($host, $usuario, $senha, $banco);

    if(mysqli_connect_errno()){
        exit("Erro ao conectar-se ao banco de dados: ". mysqli_connect_error());
    }
?>