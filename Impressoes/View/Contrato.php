<?php
$erros = [];

require_once("../Model/Paciente.php");
require_once("../Model/Orcamento.php");
require_once("../Model/Procedimento.php");
require_once("../Model/Pagamento.php");
require_once("../Model/PagParPro.php");
require_once ("../Model/Dente.php");
require_once ("../Model/Servico.php");



require_once("../Controller/PacienteController.php");
require_once("../Controller/OrcamentoController.php");
require_once("../Controller/ProcedimentoController.php");
require_once("../Controller/PagamentoController.php");
require_once("../Controller/PagParProController.php");
require_once("../Controller/DenteController.php");
require_once("../Controller/ServicoController.php");


$pacienteController = new PacienteController();

$orcamentoController = new OrcamentoController();
$pagamentoController = new PagamentoController();
$pagparproController = new PagParProController();
$procedimentoController = new ProcedimentoController();
$denteController = new DenteController();
$servicoController = new ServicoController();

$cod = 0;
$nome = "";
$nascimento = "";
$rg = "";
$cpf = "";
$endereco = "";
$numero = "";
$complemento = "";
$celular = "";
$residencial = "";
$responsavel = "";
$indicacao = "";
$data = "";
$status = "";

$id = 0;
$cod_usu = 0;
$dentista_antes = "";
$reacao_anestesia = "";
$como = "";
$alergia_medicamento = "";
$qual = "";
$outras_alergias = "";
$doencas = "";
$outra_doenca = "";
$doenca_familia = "";
$medicamento = "";
$data2 = "";
$resultado = "";

$listaPacientesBusca = [];
$listaAnamnesesBusca = [];
$listaOrcamentos = [];
$listaPagamentos = [];
$listaPagParPro = [];


$id = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
$tipo = 2;
$listaOrcamentos = $orcamentoController->RetornarOrcamentos($tipo, $id);
?>

<?php
if ($listaOrcamentos != null) {
    foreach ($listaOrcamentos as $user4) {
        ?>
        <hr class="mb-4"> 

        <table style="border: 1px solid #000; width: 100%;">
            <tr>
                <td ><img src="../Interface/img/icon.png" style="width: 40%;"></td>
                <td colspan="2" style="text-align: center; font-size: 24pt;"> Clinica Odontológica - Sorrident</td>
                <td style="text-align: right;" >CRO: 15422-55</td>

            </tr>
            <tr>
                <td colspan="4" style="text-align: center;">
                    <hr class="mb-4">
                    <h2 class="mb-3">Financeiro do Orçamento nº  <?= $user4->getCod(); ?></h2>

                </td>
            </tr>


            <?php
            $id2 = $user4->getCod();
            $listaPagamentos = $pagamentoController->RetornarPagamentos($id2);

            if ($listaPagamentos != null) {
                foreach ($listaPagamentos as $user5) {
                    ?>
                    <tr>
                        <td colspan="4" style="text-align: left; margin-left: 10px;">
                            <h2 class="mb-3">Pagamento: nº <?= $user5->getCod(); ?></h2>
                            <?php
                            $cod_pac = $user5->getCod();
                            ?>
                        </td>
                    </tr>              

                    <tr>
                        <td colspan="4" style="text-align: left; margin-left: 10px;">
                            <?php
                            if ($user5->getTipo() != 3) {
                                ?>

                                <?php
                                $pontos = ',';
                                $valor_completo = $user5->getTotal();
                                $valor_parcela = $user5->getTotal();
                                $result = str_replace($pontos, "", $valor_completo);
                                $valor_completo = (float) $result;

                                $valor_completo = number_format($valor_completo, 2, ',', '.');
                                ?>
                                <p style="color:blue; font-size: 14pt;">Valor de pagamento: <?= $valor_completo; ?> </p>   

                                <?php
                            } else {
                                $valor_parcela = $user5->getTotal();
                            }
                            ?>
                        </td>
                    </tr>   
                    <tr>
                        <td colspan="4" style="text-align: left; margin-left: 10px;">
                            <hr class="mb-4">
                            <p style="color:blue; font-size: 14pt;">Descrição:  <?= $user5->getDescricao(); ?></p>    
                             <hr class="mb-4">
                        </td>
                    </tr>  

                    <tr>
                        <td colspan="4" style="text-align: left; margin-left: 10px;">

                            <?php
                            if ($user5->getTipo() == 2) {
                                ?>
                                <p style="color:blue; font-size: 14pt;">Parcelas:  <?= $user5->getNumparcelas(); ?></p> 
                                <?PHP
                                $qtdparcela = $user5->getNumparcelas();
                                ?>

                                <?php
                            } else {
                                $qtdparcela = 1;
                            }
                            ?>  
                        </td>
                    </tr>  
                    <tr>
                        <td colspan="4" style="text-align: left; margin-left: 10px;">
                            <hr class="mb-4">
                            <?PHP
                            $pontos = ',';

                            $result = str_replace($pontos, "", $valor_parcela);
                            $valor_parcela = (float) $result;

                            $totaltotal = ($qtdparcela) * ($valor_parcela);
                            $totaltotal = number_format($totaltotal, 2, ',', '.');
                            ?>
                            <p style="color:blue;">Total: <?= $totaltotal; ?></p> 

                        </td>
                    </tr>  

                    <tr>
                        <td colspan="4" style="text-align: left; margin-left: 10px;">
                            <hr class="mb-4">

                            <?php
                            if ($user5->getTipo() == 1) {
                                ?>
                                <p style="color:blue;">Tipo: á Vista </p>    
                                <p style="color:green;">Em: <?= $user5->getTipopag(); ?> </p>    
                                <hr class="mb-4">
                                <?php
                            } else if ($user5->getTipo() == 2) {
                                ?>

                                <?PHP
                                $listaPagParPro = $pagparproController->RetornarM($cod_pac);
                                if ($listaPagParPro != null) {
                                    $contador = 1;
                                    $contador2 = 0;

                                    foreach ($listaPagParPro as $user6) {
                                        //var_dump($listaPagParPro);
                                        $contador = $contador + 1;
                                        $contador2 = $contador2 + 1;
                                        ?>

                                        <div class="card">
                                            <div class="card-body">
                                                <p style="color:blue;">Descrição:  <?= $user6->getDescricao(); ?></p>    
                                                <p style="color:green;">Valor: <?= number_format($user6->getValor(), 2, ',', '.'); ?></p>    
                                                <p style="color:#007bff;">Data:  <?= $user6->getDia() . '/' . $user6->getMes() . '/' . $user6->getAno(); ?></p>    
                                                <p style="color:#007bff;">Pagamento em:  <?= $user6->getTipopag(); ?></p>    

                                            </div>
                                        </div>
                                        <hr>

                                        <?php
                                    }
                                    ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <?php
                                            if ($qtdparcela != $contador2) {
                                                echo "<p>Pagamento Pedente!</p>";
                                            } else {
                                                echo "<p>Pagamento encerrado!</p>";
                                            }
                                            ?>
                                            <hr class="mb-4">
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>

                                    <p style="color:blue;">Tipo de Pagamento: Parcelado </p>    
                                    <hr class="mb-4">
                                    <?php
                                }
                            } else if ($user5->getTipo() == 3) {
                                $listaPagParPro = $pagparproController->RetornarTodos($cod_pac);
                                ?>
                                <p style="color:blue;">Tipo de Pagamento: Por Procedimento </p>    

                                <?PHP
                                $o = $user4->getCod();
                                $termo = "Nós é zika irmão";
                                $tipo = 1;
                                $status = $o;
                                $cont = 0;
                                $listaProcedimentos = $procedimentoController->RetornarProcedimentos($termo, $tipo, $status);
                                // var_dump($listaProcedimentos); 
                                if ($listaProcedimentos != null) {
                                    ?>
                                    <table class="table table-dark">
                                        <thead>
                                            <tr  style="">
                                                <th scope="col">Valor</th>
                                                <th scope="col">Serviço</th>
                                                <th scope="col">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($listaProcedimentos as $user10) {
                                                $cont++;
                                                $cod_procedimento3 = $user10->getCod();
                                                $valor = $user10->getValor();
                                                $string = $valor;
                                                $stringCorrigida = str_replace(',', '', $string);
                                                $valor = $stringCorrigida;
                                                $valor = (float) $valor;
                                                $valor = number_format($valor, 2, ',', '.');
                                                $status = $user10->getStatus();

                                                $servicocod = $user10->getServico();
                                                $listaServicos = $servicoController->RetornarServicos2($servicocod);

                                                if ($listaServicos != null) {
                                                    foreach ($listaServicos as $user1) {
                                                        $nome_s = $user1->getNome();
                                                        $descricao = $user1->getDescricao();
                                                        $valor_padrao = $user1->getValor();
                                                    }
                                                }

                                                if ($user10->getStatus() == 1) {
                                                    $cor = "bg-dark";
                                                    $texto = "Aberto";
                                                }
                                                if ($user10->getStatus() == 2) {
                                                    $cor = "bg-primary";
                                                    $texto = "Realizado";
                                                }
                                                if ($user10->getStatus() == 3) {
                                                    $cor = "bg-success";
                                                    $texto = "Pago";
                                                }

                                                if ($user10->getStatus() == 10) {
                                                    $cor = "bg-danger";
                                                    $texto = "Cancelado";
                                                }
                                                ?>
                                                <tr class="<?= $cor; ?>">
                                                    <th scope="col"><?= $valor; ?></th>
                                                    <th scope="col"><?= $nome_s; ?></th>
                                                    <th scope="col">.

                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="4">
                                                        <p style="color:green; text-align: center; width: 100%;"> <img style="width: 24px;" src="../Interface/img/tick-inside-circle.png">Pago</p>

                                                    </th>
                                                </tr>

                                                <?PHP
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <?php
                                }
                                ?>

                                <?php
                            }
                            ?>

                        </td>
                    </tr>



                    <?php
                }
            }
            ?>
        </table>
        <?php
    }
}
?>
