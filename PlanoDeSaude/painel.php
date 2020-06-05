<?php
$codF = 0;
$nomeF = "";
$funcaoF = 0;
$cod_orgaoF = 0;
$fotoF = "";
$permissaoF = 0;
session_start();
if (!isset($_SESSION["permissaoF"]) || $_SESSION["permissaoF"] != 1) {
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
        <title>SISO - PLANO DE SAÚDE   </title>
        <link href="../Interface/Bootstrap/bootstrap.min.css" rel="stylesheet" />
        <link href="../Util/functions.php" rel="stylesheet" />

    </head>

    <body class="bg-white" style="background-color: #ccc;">
        <nav class="navbar navbar-expand-lg  navbar-dark bg-dark" style="background-color: #fff;">
            <a class="navbar-brand" href="#"><span class="oi oi-person"></span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent" >
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="painel.php"><img src='../glyph/svg/si-glyph-abacus.svg' style="width: 25px; "> Início</a>
                    </li>
                    <li class="nav-item <?php if ($_GET['pagina']=='financeiro') {echo 'active';} ?>">
                        <a class="nav-link" href="painel.php?pagina=financeiro"><img src='../glyph/svg/si-glyph-abacus.svg' style="width: 25px; "> Financeiro</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><img src='../glyph/svg/si-glyph-abacus.svg' style="width: 25px; ">Sair</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main" class="container">
            <?php
            require_once("../Util/RequestPagePlano.php");
            ?>   
                <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a class="dropdown-item" href="painel.php?pagina=servico">Serviços</a>

                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a class="dropdown-item" href="painel.php?pagina=catserfin">Categoria de Serviços e Financeiro</a>

                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a class="dropdown-item" href="../Usuarios/painel.php">Usuarios</a>
                </li>
            </ul>

            <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded box-shadow" style="background-color:#778899">
        <!--  <img class="mr-3" src="Interface/img/logo1.png" alt="" width="60" height="60"> -->
                <div class="lh-100">
                    <h6 class="mb-0 text-white lh-100">@</h6>
                    <small>Since 2020</small>
                    </br>
                </div>
            </div>

        </main>
       
    </body>

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="../Interface/Bootstrap/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="../Interface/Bootstrap/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="../Interface/Bootstrap/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</html>