<?php

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_STRING);

$arrayPaginas = array(
    "teste" => "View/teste.php",
    "home" => "View/home.php", //Página inicial
    "meuspedidos" => "View/meuspedidos.php", //Página inicial
    "meusdados" => "View/MeusDadosCadastrais.php", //Página inicial
    "alterarsenha" => "View/UsuarioView/AlterarSenhaView.php",
    "alterarfoto" => "View/UsuarioView/AlterarImagem.php",
    "produtos" => "View/ClassificadoView/ClassificadoView.php",
    "categoria" => "View/CategoriaView/CategoriaView.php",
    "categoriaimagem" => "View/CategoriaView/AlterarImagem.php",
    "gerenciarimagemclassificado" => "View/ClassificadoView/ImagensClassificadoView.php",
    "visualizarclassificado" => "View/ClassificadoView/VisualizarClassificado.php",
    "parte1" => "View/PedidoView/PedidoParte1.php",
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