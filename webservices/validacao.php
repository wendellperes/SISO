<?php
$tipo = $_GET['tipo'];

switch ($tipo) {
    case 1:
        // Valor do campo que fez requisição
        if ($_GET['param'] != null) {
            $qtd = $_GET['param'];
        } else {
            $qtd = 1;
        }
        $valor = $_GET['valor'];

        $valor = (float) $valor;
        $qtd = (float) $qtd;

        $valorTotal = $valor * $qtd;
        $valorTotal = number_format($valorTotal, 2, ',', '.');

        echo "
                    <label for='txtValor_total'>Total:</label>
                    <input type='text' class='form-control' id='txtValor_total' name='txtValor_total' placeholder='' value='$valorTotal' required='' disabled='' />
                    <input type='hidden' name='txtValor_total' id='txtValor_total' value='$valorTotal' />
                ";
        break;

    case 2:
        // Valor do campo que fez requisição
        if ($_GET['param'] != null) {
            $qtd = $_GET['param'];
        } else {
            $qtd = 1;
        }
        $qtdatual = $_GET['valor'];

        $qtdatual = (float) $qtdatual;

        $qtd = (float) $qtd;

        $qtdtruefalse = $qtdatual - $qtd;

        if ($qtdtruefalse >= 0) {
            echo "
                    <label for='txtqtd_saida'>.</label>
                    <input style='width:100%;' class='btn btn-outline-success btn-lg' type='submit' name='btnCadastrarSaidaL' id='btnCadastrarSaidaL' value='Add+'/>
                                                                    
                ";
        } else {
            echo "<div class='alert alert-warning'>Quantidade solicitada acima do estoque atual</div>";
        }

        break;
}
// Acentuação
header("Content-Type: text/html; charset=ISO-8859-1", true);
?>