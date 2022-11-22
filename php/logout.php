<?php
    require './db/conexao.php';

    // EXCLUI O COOCKIE
    $validade = strtotime("-1 month");
    setcookie('email', '', $validade, '/', '', false, true);

    session_destroy();

    header('location: ./../index.php');