<?php
$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_STRING);

$arrayPaginas = array(
    "home" => "View/home.php", //Página inicial
    "entradas" => "View/EntradasView.php",
    "saidas" => "View/SaidasView.php",
    "relatorios" => "View/RelatoriosView.php",
    "produtos" => "View/ViewProdutos/VisualizarProdutos.php",
    "consulta" => "View/ConsultasView.php"
);


if ($pagina) {
    $encontrou = false;

    foreach ($arrayPaginas as $page => $key) {
        if ($pagina == $page) {
            $encontrou = true;
            require_once($key);
        }
    }

    if (!$encontrou) {
        require_once("View/home.php");
    }
} else {
    require_once("View/home.php");
}
?>