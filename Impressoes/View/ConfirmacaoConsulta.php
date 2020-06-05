<?php
$erros = [];

require_once("../Model/Paciente.php");
require_once("../Model/Orcamento.php");
require_once("../Model/Procedimento.php");
require_once ("../Model/Servico.php");
require_once ("../Model/Dente.php");
require_once("../Controller/PacienteController.php");
require_once("../Controller/OrcamentoController.php");
require_once("../Controller/ProcedimentoController.php");
require_once("../Controller/ServicoController.php");
require_once("../Controller/DenteController.php");


$pacienteController = new PacienteController();
$orcamentoController = new OrcamentoController();
$servicoController = new ServicoController();
$denteController = new DenteController();
$procedimentoController = new ProcedimentoController;

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


$listaProcedimentos = [];

$cod_procedimento = 0;
$cod_dente = 0;
$cod_servico = 0;
$cod_orcamento = 0;
$valor = "";
$nivel = 0;
$obs = "";
$tipo = 0;
$data = "";
$status = "";
$resultado = "";

$erros = [];

$listaPacientesBusca = [];

$listaOrcamentos = [];

$listaServicos = [];

if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {

    $id = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
    $tipo = 2;
    $listaOrcamentos = $orcamentoController->RetornarOrcamentos($tipo, $id);
}
$cont = 0;
//var_dump($listaOrcamentos);
?>
<html lang="pt"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../Interface/img/icon.png">

        <title>PLANO DE SAÚDE - SORRIDENT</title>

        <link href="../Interface/Bootstrap/bootstrap.min.css" rel="stylesheet" />


    </head>

    <body>

        <?php
        if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {

            if ($listaOrcamentos != null) {
                foreach ($listaOrcamentos as $user4) {
                    $o = $user4->getCod();
                    $termo = "Nós é zika irmão";
                    $tipo = 1;
                    $status = $o;
                    $listaProcedimentos = $procedimentoController->RetornarProcedimentos($termo, $tipo, $status);
                    ?>

                    <?php
                    if ($user4->getStatus() == 1) {
                        $texto = "Aberto";
                    }
                    if ($user4->getStatus() == 2) {
                        $texto = "Em andamento";
                    }
                    if ($user4->getStatus() == 3) {
                        $texto = "Pago";
                    }
                    if ($user4->getStatus() == 4) {
                        $texto = "Completo";
                    }
                    ?>
                    <table style="border: 1px solid #000; margin-left: 10%; width: 80%;" class="table table-bordered">
                        <tr>
                            <td style="text-align: center;" ><img src="../Interface/img/logoplano.png" style="width: 50%; "></td>
                            <td colspan="3" style="text-align: center;"></br></br><b>Sorrident - Clínica Odontológica Especializada</b></td>
                            
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: center;">
                                <h2 class="mb-3">Confirmação de consulta</h2>
                            </td>
                            <td>Data:</br>
                                <?= $user4->getDia() ?>/<?= $user4->getMes() ?>/<?= $user4->getAno() ?> 
                            </td>
                        </tr>
                        <?php
                        if ($listaProcedimentos != null) {
                            foreach ($listaProcedimentos as $user4) {
                                $cont++;
                                $cod_proc = $user4->getCod();
                                $cod_dente = $user4->getDente();
                                $cod_servico = $user4->getServico();
                                $nivel = $user4->getNivel();
                                $tipo = $user4->getTipo();

                                if ($tipo == 0) {
                                    $tipo = "Estético";
                                } else {
                                    $tipo = "Cirurgico";
                                }

                                $status = $user4->getStatus();

                                if ($status == 1) {
                                    $status = "Aberto";
                                }
                                if ($status == 2) {
                                    $status = "Realizado";
                                }
                                if ($status == 3) {
                                    $status = "Pago";
                                }

                                $obs = $user4->getObs();
                                $valor_procedimento = $user4->getValor();
                                $string = $valor_procedimento;
                                $stringCorrigida = str_replace(',', '', $string);

                                $valor_procedimento = number_format($stringCorrigida, 2, ',', '.');
                                ?>
                                <?php
                                $listaDentes = $denteController->RetornarDentes2($cod_dente);
                                if ($listaDentes != null) {
                                    foreach ($listaDentes as $user0) {

                                        $cod_dente = $user0->getCod();
                                        $nome = $user0->getNome();
                                        $descricao = $user0->getDescricao();
                                        $quadrante = $user0->getQuadrante();
                                        $imagem = $user0->getImagem();
                                    }
                                }
                                ?>
                                <tr>
                                    <th><small style="color:#0062cc; text-align: left;">Dente nº: </small></th>
                                    <td><?= $nome ?></td>
                                    <th><small style="color:#0062cc; text-align: left;">Descrição/Quadrante</small></th>
                                    <td><?= $descricao . "/Quadrante: " . $quadrante; ?></td>
                                </tr>

                                <?php
                                $listaServicos = $servicoController->RetornarServicos2($cod_servico);

                                if ($listaServicos != null) {
                                    foreach ($listaServicos as $user1) {

                                        $nome = $user1->getNome();
                                        $descricao = $user1->getDescricao();
                                        $valor_padrao = $user1->getValor();
                                    }
                                }
                                ?>
                                <tr>
                                    <th><small style="color:#0062cc; text-align: left;">Serviço: </small></th>
                                    <td><?= $nome ?></td>
                                    <th><small style="color:#0062cc; text-align: left;">Descrição</small></th>
                                    <td><?= $descricao ?></td>
                                </tr>
                                <tr>
                                    <th style=""><small style="color:#0062cc; text-align: left;">Obs:</small></th>
                                    <td colspan="3" style="text-align: left;">
                                         
                                        <?= $user4->getObs(); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: left;">
                                        <hR>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        $cont = 0;
                        ?>
                    </table>
                    <?php
                }
            }
        }
        ?>



    </body>



    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="../Interface/Bootstrap/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="../Interface/Bootstrap/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="../Interface/Bootstrap/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</html>

