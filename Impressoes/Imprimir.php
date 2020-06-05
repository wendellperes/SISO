<?php
$codF = 0;
$nomeF = "";
$funcaoF = 0;
$cod_orgaoF = 0;
$fotoF = "";
$permissaoF = 0;
session_start();
if (!isset($_SESSION["permissaoF"])) {
    header("Location: index.php");
} else {
    $codF = (int) $_SESSION['codF'];
    $nomeF = $_SESSION['nomeF'];
    $permissaoF = (int) $_SESSION['permissaoF'];
}
date_default_timezone_set('America/Manaus');
?>﻿<!DOCTYPE html>

<html lang="pt"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../Interface/img/logoplano.png">
        <script type="text/javascript" src="funcs.js"></script>
        <title>Sorrident - Plano de Saúde</title>
        <link href="../Interface/Bootstrap/bootstrap.min.css" rel="stylesheet" />

    </head>

    <body class="bg-white" style="background-color: #ccc;">
        
        <main role="main" class="container">
            <?php
            require_once("../Util/RequestPageImp.php");
            ?>   
        </main>
       

    </body>

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="../Interface/Bootstrap/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="../Interface/Bootstrap/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="../Interface/Bootstrap/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</html>