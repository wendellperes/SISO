<?php
session_start();

require_once("../Controller/UsuarioController.php");
require_once("../Model/Usuario.php");

$resultado = "&nbsp;";

if (filter_input(INPUT_POST, "btnEntrar", FILTER_SANITIZE_STRING)) {
    $funcionariosController = new UsuarioController();
    $login = filter_input(INPUT_POST, "txtLogin", FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, "txtSenha", FILTER_SANITIZE_STRING);
    $permissao = 1;

    $resultado = $funcionariosController->AutenticarUsuario($login, $senha, $permissao);

    if ($resultado != null) {
        

        $_SESSION["codF"] = $resultado->getCod();
        $_SESSION["nomeF"] = $resultado->getNome();
        $_SESSION["permissaoF"] = 1;
        $_SESSION["logadoF"] = true;
        header("Location: ../PlanoDeSaude/painel.php");
    } else {
        
        echo '<script>alert("nao veio diferente");</script>';
        $retorno = "<div class=\"alert alert-danger\" role=\"alert\">Usuário ou senha inválido.</div>";
    }
}
?>
<!doctype html>
<!DOCTYPE html>
<!-- saved from url=(0054)https://getbootstrap.com.br/docs/4.1/examples/sign-in/ -->
<html lang="pt-br"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../Interface/img/logoplano.png"><!-- Trocar Icone -->

        <title>Login - Sorrident Plano de Saúde.</title>

        <!-- Principal CSS do Bootstrap -->
        <link href="../Interface/Bootstrap/bootstrap.min.css" rel="stylesheet">
        <!-- Estilos customizados para esse template -->
        <link href="../Interface/Bootstrap/signin.css" rel="stylesheet">

    <body class="text-center">
        <form method="post" name="frmCadastro" id="frmCadastro" class="form-signin" novalidate enctype="multipart/form-data">
            <img class="mb-4" src="../Interface/img/logoplano.png" alt="" width="200" height="200">
            <div style="margin-top: -10px;">
                <h1 class="h3 mb-3 font-weight-normal">Faça login</h1>
                <label for="txtLogin" class="sr-only">Endereço de email</label>
                <input  type="text" id="txtLogin" name="txtLogin" class="form-control" placeholder="Digite seu email" required="" autofocus="">
                <label  for="txtSenha" class="sr-only">Senha</label>
                <input style="margin-top:10px;" type="password" id="txtSenha" name="txtSenha" class="form-control" placeholder="Senha" required="">
                <input class="btn btn-lg btn-primary btn-block" type="submit" name="btnEntrar" id="btnEntrar" value="Login">
                <p class="mt-5 mb-3 text-muted">©SORRIDENTE 2019</p>
            </div>
        </form>


    </body></html>