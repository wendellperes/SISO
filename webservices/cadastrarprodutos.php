<?php
session_start();    
// Incluir aquivo de conex�o
include("conn.php");
$codnota=0;
$cod_orgao = $_SESSION['cod_orgaoF'];
$valor = $_GET['valor'];
$codnota = $_GET['codnota'];
// Procura titulos no banco relacionados ao valor
$sql = mysqli_query($conn, "SELECT * FROM servicos WHERE nome LIKE '%" . $valor . "%' LIMIT 5");

// Exibe todos os valores encontrados
while ($servicos = mysqli_fetch_object($sql)) {
    $categoria = $servicos->categoria;
    $sql2 = mysqli_query($conn, "SELECT * FROM categoriaserfin WHERE cod=" . $categoria . " LIMIT 1");
    while ($categorias = mysqli_fetch_object($sql2)) {
        $nomecategoria = $categorias->nome;
    }

    $usuario = (int) $_SESSION['codF'];
        
    $codservico = $servicos->cod;
    $valor = $servicos->valor;
    
    echo "<a href=\"javascript:func()\" onclick=\"CadastrarPedido('" . $codservico . "', '" . $codnota . "', '" . $valor . "', '" . $categoria . "')\" class=\"list-group-item btn btn-info\">" . $servicos->nome . "<span style=\"color:green\"> (" . $nomecategoria . ")</span> - <small>Valor R$:   " . number_format($servicos->valor, 2, ',', '.') . "</small></a>
       ";
}

// Acentua��o
header("Content-Type: text/html; charset=ISO-8859-1", true);
?>