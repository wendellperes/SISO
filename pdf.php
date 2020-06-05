<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>

<?php
require_once ("../Model/Pedido.php");
require_once ("../Controller/PedidoController.php");

$pedidoPDFController = new PedidoController();

$PDF = $pedidoPDFController->PDF($_GET['cod']);

foreach ($PDF as $r) {
    $lp = str_replace("-", "<td class='td'>", $r->getProduto());
    $lp = str_replace("/", "</td>", $lp);
    $lp = str_replace("|", "<tr>", $lp);
    $lp = str_replace("!", "</tr>", $lp);


    require_once("../mpdf60/mpdf.php");
    $dompdf = new mPDF();
    $pdf = '
            <div id="global">
                <div id="d">----------- DeliveryCoari -----------</div>
                <div class="info">-'.$r->getRestaurante_id().'</div>
                <div class="info">-'.$r->getUsuario_id().'</div>
                <div class="endereco"><span class="n">Endereço: </span>'.$r->getRua()." - ". $r->getBairro()." N°". $r->getNumero().'</div>
                <div class="endereco"><span class="n">Complemento: </span>'.$r->getComplemento().'</div>
				<div class="endereco"><span class="n">__________________________</span></div>
                 <div class="endereco"><span class="n">Produto --------- Valor</div>
                <table id="table">                 
                    <tbody>
                        ' . $lp . '
                            <tr><td colspan="2" class="tbltitle vt"><span class="n">Valor Total:</span> R$ '.number_format($r->getValorT(),2,",",".").'</td></tr>
                    </tbody>
                </table>
				<div class="endereco"><span class="n">__________________________</span></div>
            </div>';
}
$mpdf = new mPDF();
$mpdf->SetDisplayMode('fullpage');
$css = file_get_contents("../css/estiloPDF.css");
$mpdf->WriteHTML($css, 1);
$mpdf->WriteHTML($pdf);

$mpdf->Output();
exit;
?>