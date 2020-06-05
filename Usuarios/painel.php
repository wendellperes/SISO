<!DOCTYPE html>

<html lang="pt"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">



        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../Interface/img/icon.png">

        <title>Usuários/ Sisven</title>

        <link href="../Interface/Bootstrap/bootstrap.min.css" rel="stylesheet" />


    </head>

    <body class="bg-light">
        <nav class="navbar navbar-expand-lg  navbar-dark bg-dark" style="background-color: #e3f2fd;">
            <a class="navbar-brand" href="#"><span class="oi oi-person"></span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="painel.php">Início <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="painel.php?pagina=usuario">Novo Usuário</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="../Administrador/painel.php?">Administrador</a>
                    </li>
                </ul>
                

            </div>
        </nav>
        <main role="main" class="container">
            <?php
            require_once("../Util/RequestPageUsu.php");
            ?>   


            <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded box-shadow" style="background-color:#778899">
        <!--  <img class="mr-3" src="Interface/img/logo1.png" alt="" width="60" height="60"> -->
                <div class="lh-100">
                    <h6 class="mb-0 text-white lh-100">@Elanddji</h6>
                    <small>Since 2017 - 2018</small>
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