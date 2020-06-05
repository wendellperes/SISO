<?php
$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_STRING);

$arrayPaginas = array(
    "home" => "View/home.php", //Página inicial
    "visualizar" => "View/VisualizarView.php",
    "financeiro" => "View/RelatoriosView.php",
    "confirmarevento" => "View/ConfirmarEventoView.php", 
    "servico" => "View/ServicosView.php",
    "catserfin" => "View/CategoriaSerFinView.php",	  
    "consulta" => "View/ConsultaView.php"
    
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