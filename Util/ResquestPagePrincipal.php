<?php
$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_STRING);

$arrayPaginas = array(
    "home" => "View/home.php", //Página inicial
    "notas" => "View/NotasView.php", //Página inicial
    "clientes" => "View/ClientesView/ClientesView.php",
    "visualizar" => "View/ClientesView/VisualizarClientes.php",
    "pesquisarcliente" => "View/PesquisarClienteView.php"
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