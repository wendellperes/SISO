<?php
$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_STRING);

$arrayPaginas = array(
    "1" => "View/BalancoMensal.php", //Página inicial
    "2" => "View/BalancoAnual.php",
    "3" => "View/DadosCadastrais.php",
    "4" => "View/DadosCompleto.php",
    "5" => "View/ConfirmacaoConsulta.php",
    "6" => "View/Contrato.php",
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
        require_once("View/Entradas.php");
    }
} else {
    require_once("View/Entradas.php");
}
?>