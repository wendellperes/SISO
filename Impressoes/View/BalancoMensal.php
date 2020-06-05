<?php
require_once("../Model/Paciente.php");
require_once("../Controller/PacienteController.php");
require_once("../Model/Orcamento.php");
require_once("../Controller/OrcamentoController.php");
require_once("../Model/Pagamento.php");
require_once ("../Model/AtivoPassivo.php");
require_once("../Controller/PagamentoController.php");
require_once("../Controller/MovimentoPacController.php");
require_once("../Controller/ListaesperaController.php");
require_once("../Model/Listaespera.php");
require_once ("../Controller/MovimentoController.php");
require_once ("../Model/CategoriaFinanceiro.php");
require_once ("../Controller/CategoriaFinanceiroController.php");
require_once ("../Model/Movimento.php");
require_once ("../Model/CategoriaFinanceiro.php");
require_once("../Model/Usuario.php");
require_once("../Controller/UsuarioController.php");

require_once("../Util/functions.php");

$pacienteController = new PacienteController();
$orcamentoController = new OrcamentoController();
$pagamentoController = new PagamentoController();
$movimentopacController = new MovimentoPacController();
$listaesperaController = new ListaesperaController();
$movimentoController = new MovimentoController();
$CategoriaFinanceiroController = new CategoriaFinanceiroController();
$usuarioController = new UsuarioController();


$resultado = '';

if (isset($_GET['dia'])) {
    $dia_hoje = $_GET['dia'];
} else {
    $dia_hoje = date('d');
}

if (isset($_GET['mes'])) {
    $mes_hoje = $_GET['mes'];
} else {
    $mes_hoje = date('m');
}
if (isset($_GET['ano'])) {
    $ano_hoje = $_GET['ano'];
} else {
    $ano_hoje = date('Y');
}

date_default_timezone_set('America/Manaus');

$resultado = "";
$erros = [];
$ListaBuscaMovMes = [];
$ListaBuscaMovAno = [];

//FINANCEIRO EMPRESA INICIO

$listamovimentosPorMes = [];
$ListaCategoria = [];

$id = 0;
$tipo = 1;
$cat = 1;
$descricao = "";
$valor = 0;
$cod_usu = 1;

$listamovimentosPorMes = $movimentoController->RetornarMes($cod_usu, $mes_hoje, $ano_hoje);
$listamovimentosCompleto = $movimentoController->RetornarTodos($cod_usu, $ano_hoje);

$categoria = 1;

$ListaCategoriass = [];
$ListaCategoriass = $CategoriaFinanceiroController->RetornarCategorias($cod_usu);


$entrada = 0;
$saida = 0;


if ($listamovimentosPorMes != null) {
    foreach ($listamovimentosPorMes as $movimento) {
        if ($movimento->getTipo() == 1) {
            $entrada = $entrada + $movimento->getValor();
        } else {
            $saida = $saida + $movimento->getValor();
        }
    }
}

$entradaAno = 0;
$saidaAno = 0;
if ($listamovimentosCompleto != null) {
    foreach ($listamovimentosCompleto as $movimento) {
        if ($movimento->getTipo() == 1) {
            $entradaAno = $entradaAno + $movimento->getValor();
        } else {
            $saidaAno = $saidaAno + $movimento->getValor();
        }
    }
}

if (filter_input(INPUT_POST, "btnCadastrar", FILTER_SANITIZE_STRING)) {
    $data_movimento = (filter_input(INPUT_POST, "txtData", FILTER_SANITIZE_STRING));
    $tipo_movimento = (filter_input(INPUT_POST, "txtTipo", FILTER_SANITIZE_STRING));
    $cat_movimento = (filter_input(INPUT_POST, "txtCat", FILTER_SANITIZE_NUMBER_INT));
    $valor_movimento = (filter_input(INPUT_POST, "txtValor", FILTER_SANITIZE_STRING));
    $descricao_movimento = (filter_input(INPUT_POST, "txtDescricao", FILTER_SANITIZE_STRING));

    $pontos = '.';
    $result = str_replace($pontos, "", $valor_movimento);

    $pontos = ',';
    $result = str_replace($pontos, ".", $result);


    $valor_movimento = number_format($result, 2, '.', '');


    $t = explode("/", $data_movimento);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];

    $movimento = new Movimento();
    $movimento->setTipo($tipo_movimento);
    $movimento->setDia($dia);
    $movimento->setMes($mes);
    $movimento->setAno($ano);
    $movimento->setCat($cat_movimento);
    $movimento->setDescricao($descricao_movimento);
    $movimento->setValor($valor_movimento);
    $movimento->setCod_usu(1);


    if ($movimentoController->Cadastrar($movimento)) {
        $resultado = " <div class='alert alert-success' role='alert'><span>Movimento cadastrado com sucesso!</span> </div>";
    } else {
        $resultado = "Houve um erro ao cadastrar movimento";
    }
}

if (filter_input(INPUT_POST, "btnEnviar", FILTER_SANITIZE_STRING)) {
    $mes_filtro_cat = (filter_input(INPUT_POST, "mes", FILTER_SANITIZE_NUMBER_INT));
    $ano_filtro_cat = (filter_input(INPUT_POST, "ano", FILTER_SANITIZE_NUMBER_INT));
    $cat_filtro_cat = (filter_input(INPUT_POST, "filtro_cat", FILTER_SANITIZE_NUMBER_INT));

    $listamovimentosPorMes = $movimentoController->RetornarPorCategoria(1, $mes_filtro_cat, $ano_filtro_cat, $cat_filtro_cat);
} else {
    $listamovimentosPorMes = $movimentoController->RetornarPorCategoria(1, $mes_hoje, $ano_hoje, 1);
}


// FINANCEIRO EMPRESA FIM
//FINANCEIRO PLANO DE SAUDE INICIO

$ativopassivo22 = 1;
$ListaMesAP = $movimentopacController->RetornarMesAP(1, $mes_hoje, $ano_hoje);

$ListaMesAP2 = $movimentopacController->RetornarMesAP(2, $mes_hoje, $ano_hoje);
//var_dump($ListaMesAP);
//FINANCEIRO PLANO DE SAUDE FIM
?>


<style>
    #eusouomestre:hover{
        color:#fff;
    }
</style>
<link href="../Interface/Bootstrap/responsividade.css" rel="stylesheet" type="text/css"/>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <td colspan="4" style="text-align: center; font-size: 16pt;">                         
                    <img src="../Interface/img/logoplano.png" style="width: 20%; "></br>
                    <b>Sorrident - Clínica Odontológica Especializada</b>
                    </br>
                </td>
            </tr>
            <tr>
                <th colspan="2" style="text-align: center;"><h4>Relatório Mensal</h4></th>
                <th colspan="2" style="text-align: center;"><h4><?= mostraMes($mes_hoje) ?>/<?= $ano_hoje; ?></h4></th>
            </tr>
        </table>
    </div>

    <?php
    $totalfinalmestipo1 = 0;
    $totalfinalmestipo2 = 0;
    $totalfinalmes = 0;

    $totalfinalanotipo1 = 0;
    $totalfinalanotipo2 = 0;
    $totalfinalano = 0;

    $valor_total = 0;
    $ListaBuscaMovMes = $movimentopacController->RetornarMes($mes_hoje, $ano_hoje);
    //   var_dump($ListaBuscaMovMes);
    if ($ListaBuscaMovMes != null) {
        foreach ($ListaBuscaMovMes as $movmes) {
            $pontos = ',';
            $result = str_replace($pontos, "", $movmes->getTotal());
            $valor_total = (float) $result;
            $totalfinalmes = $totalfinalmes + $valor_total;
            if ($movmes->getTipo() == 1) {
                $totalfinalmestipo1 = $totalfinalmestipo1 + $valor_total;
            } else if ($movmes->getTipo() == 2) {
                $totalfinalmestipo2 = $totalfinalmestipo2 + $valor_total;
            }
        }
    }
    $valor_total = 0;


    $ListaBuscaMovAno = $movimentopacController->RetornarAno($ano_hoje);
    //   var_dump($ListaBuscaMovMes);
    if ($ListaBuscaMovAno != null) {
        foreach ($ListaBuscaMovAno as $movano) {
            $pontos = ',';
            $result = str_replace($pontos, "", $movano->getTotal());
            $valor_total = (float) $result;
            $totalfinalano = $totalfinalano + $valor_total;
            if ($movano->getTipo() == 1) {
                $totalfinalanotipo1 = $totalfinalanotipo1 + $valor_total;
            } else if ($movano->getTipo() == 2) {
                $totalfinalanotipo2 = $totalfinalanotipo2 + $valor_total;
            }
        }
    }
    ?>
    <table class="table table-bordered">
        <tr><TH colspan="4" style="text-align: center;">Faturamento Mensal - Resumo</TH></tr>
        <tr>
            <td rowspan="3"></td>
            <th rowspan="3" style="text-align: right;">Faturamento Total:</th>
            <td colspan="2" style="text-align: center;">R$ <?= number_format($totalfinalmes, 2, ',', '.') ?> </td>
        </tr>
        <tr>
            <th style="text-align: center;">Recebido</th>
            <th style="text-align: center;">a Receber</th>
        </tr>
        <tr>
            <td  style="text-align: center;">R$ <?= number_format($totalfinalmestipo1, 2, ',', '.') ?> </td>

            <td  style="text-align: center;">R$ <?= number_format($totalfinalmestipo2, 2, ',', '.') ?> </td>
        </tr>


    </table>
    <table class="table table-bordered">
        <thead >
            <tr>
                <th scope="col" colspan="6"  style="text-align: center;">Parcelas Recebidas</th>
            </tr>
            <tr>
                <th scope="col"  style="text-align: center;">nº</th>
                <th scope="col"  style="text-align: center;">Paciente</th>
                <th scope="col"  style="text-align: center;">Descrição</th>
                <th scope="col"  style="text-align: center;">Data</th>
                <th scope="col"  style="text-align: center;">Valor</th>
            </tr>
        </thead>

        <?php
        $totaldomes = 0;
        $cod_paciente22 = 0 ;
        $Funcionario =0 ;
        $cont22 = 0;
        if ($ListaMesAP != null) {
            foreach ($ListaMesAP as $movtipo) {
                $cont22++;
                $pontos = ',';
                $result = str_replace($pontos, "", $movtipo->getTotal());
                $valor_total = (float) $result;
                $totaldomes = $totaldomes + $valor_total;
                $ListaBuscaOrcamento = [];

               
                ?>
                <tr>
                    <th scope="col"  style="text-align: center;"><?= $cont22; ?></th>
                    <th scope="col"  style="text-align: center;"><?= $pacienteController->RetornarNomePac($movtipo->getCod_orcamento()); ?></th>
                    <th scope="col"  style="text-align: center;"><?= $movtipo->getDescricao(); ?></th>
                    <th scope="col"  style="text-align: center;"><?= $movtipo->getDia(); ?>/<?= $movtipo->getMes(); ?>/<?= $movtipo->getAno(); ?></th>
                    <th scope="col"  style="text-align: center;">R$ <?= number_format($valor_total, 2, ',', '.'); ?></th>
                </tr>
                <?php
            }
        }
        ?>
        <tr>
            <td colspan="4" style="text-align: right;">Total Final</td>
            <th>R$ <?= number_format($totaldomes, 2, ',', '.'); ?></th>
        </tr>
        </tbody>
    </table>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col" colspan="6"  style="text-align: center;">Parcelas a Receber</th>
            </tr>
            <tr>
                <th scope="col"  style="text-align: center;">nº</th>
                <th scope="col"  style="text-align: center;">Paciente</th>
                <th scope="col"  style="text-align: center;">Descrição</th>
                <th scope="col"  style="text-align: center;">Data</th>
                <th scope="col"  style="text-align: center;">Valor</th>
            </tr>
        </thead>

        <?php
        $totaldomes = 0;
        $cont22 = 0;
        if ($ListaMesAP2 != null) {
            foreach ($ListaMesAP2 as $movtipo) {
                $cont22++;
                $pontos = ',';
                $result = str_replace($pontos, "", $movtipo->getTotal());
                $valor_total = (float) $result;
                $totaldomes = $totaldomes + $valor_total;
                $ListaBuscaOrcamento = [];
$cod_paciente22 = 0;
$Funcionario = 0;
               
                ?>
                <tr>
                    <th scope="col"  style="text-align: center;"><?= $cont22; ?></th>
                     <th scope="col"  style="text-align: center;"><?= $pacienteController->RetornarNomePac($movtipo->getCod_orcamento()); ?></th>
                   <th scope="col"  style="text-align: center;"><?= $movtipo->getDescricao(); ?></th>
                    <th scope="col"  style="text-align: center;"><?= $movtipo->getDia(); ?>/<?= $movtipo->getMes(); ?>/<?= $movtipo->getAno(); ?></th>
                    <th scope="col"  style="text-align: center;">R$ <?= number_format($valor_total, 2, ',', '.'); ?></th>
                </tr>
                <?php
            }
        }
        ?>
        <tr>
            <td colspan="4" style="text-align: right;">Total Final</td>
            <th>R$ <?= number_format($totaldomes, 2, ',', '.'); ?></th>
        </tr>
        </tbody>
    </table>
    <table class="table table-bordered">
        <tr><TH colspan="4" style="text-align: center;">Despesa Mensal - Resumo</TH></tr>

    </table>
    <?php
    $totalfinalmes = 0;
    $totalfinalano = 0;
    $valorAno = 0;
    $valorMes = 0;
    $cont22 = 0;
    $ListaMes = [];
    $ListaMes = $movimentoController->RetornarMes(1, $mes_hoje, $ano_hoje);
    if ($ListaMes != null) {
        foreach ($ListaMes as $movimes) {
            $pontos = ',';
            $result = str_replace($pontos, "", $movimes->getValor());
            $valorMes = (float) $result;
            $totalfinalmes = $totalfinalmes + $valorMes;
        }
    }
    $ListaAno = [];
    $ListaAno = $movimentoController->RetornarTodos(1, $ano_hoje);

    if ($ListaAno != null) {
        foreach ($ListaAno as $moviano) {
            $pontos = ',';
            $result = str_replace($pontos, "", $moviano->getValor());
            $valorAno = (float) $result;
            $totalfinalano = $totalfinalano + $valorAno;
        }
    }
    ?>
    <table class='table table-bordered'>
        <tr>
            <th style="text-align: right;">Despesa Total</th>
            <td>R$ <?= number_format($totalfinalmes, 2, ',', '.'); ?></td>
        </tr>
    </table>
    <table class="table table-bordered">
        <?php
        if ($ListaCategoriass != null) {
            $totaltotalfinal = 0;
            foreach ($ListaCategoriass as $FinanceiroCategorias) {
                $listamovimentosPorMes = $movimentoController->RetornarPorCategoria(1, $mes_hoje, $ano_hoje, $FinanceiroCategorias->getId());
                if ($listamovimentosPorMes != null) {
                    ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">
                            <?= $FinanceiroCategorias->getNome(); ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"  style="text-align: center;">nº</th>
                        <th scope="col" colspan="2"  style="text-align: center;">Descrição</th>
                        <th scope="col"  style="text-align: center;">Valor</th>
                    </tr>
                    <?php
                    $totalfinal = 0;
                    foreach ($listamovimentosPorMes as $despesas) {
                        $total = 0;
                        $pontos = ',';
                        $result = str_replace($pontos, "", $despesas->getValor());
                        $valor_total = (float) $result;
                        $total = $valor_total;
                        $totalfinal = $totalfinal + $total;
                        $totaltotalfinal = $totaltotalfinal + $total;
                        ?>
                        <tr>
                            <td>
                                <?= $despesas->getId(); ?>
                            </td>
                            <td colspan="2">
                                <?= $despesas->getDescricao(); ?>
                            </td>
                            <td>
                                R$ <?= number_format($total, 2, ',', '.') ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td colspan="3" style="text-align: right"><b>Total</b></td>
                        <td><b>R$ <?= number_format($totalfinal, 2, ',', '.') ?></b></td>
                    </tr>
                    <?php
                }
            }
        }
        ?>

        <tr>
            <th colspan="4"><hr></th>
        </tr>
        <tr>
            <th colspan="3" style="text-align: right;">Total Final Despesa:</th>
            <td>R$ <?= number_format($totaltotalfinal, 2, ',', '.') ?></td>
        </tr>
    </table>

</div>

