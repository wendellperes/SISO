<?php
require_once("Model/Paciente.php");
require_once("Controller/PacienteController.php");
require_once("Model/Orcamento.php");
require_once("Controller/OrcamentoController.php");
require_once("Model/Pagamento.php");
require_once ("Model/AtivoPassivo.php");
require_once("Controller/PagamentoController.php");
require_once("Controller/MovimentoPacController.php");
require_once("Controller/ListaesperaController.php");
require_once("Model/Listaespera.php");
require_once ("Controller/MovimentoController.php");
require_once ("Model/CategoriaFinanceiro.php");
require_once ("Controller/CategoriaFinanceiroController.php");
require_once ("Model/Movimento.php");
require_once ("Model/CategoriaFinanceiro.php");
require_once("Model/Usuario.php");
require_once("Controller/UsuarioController.php");

require_once("Util/functions.php");

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

if (filter_input(INPUT_POST, "btnEnviarTipo", FILTER_SANITIZE_STRING)) {
    $mes_filtro_cat = (filter_input(INPUT_POST, "mes", FILTER_SANITIZE_NUMBER_INT));
    $ano_filtro_cat = (filter_input(INPUT_POST, "ano", FILTER_SANITIZE_NUMBER_INT));
    $ativopassivo22 = (filter_input(INPUT_POST, "filtro_cat", FILTER_SANITIZE_NUMBER_INT));
    $ListaMesAP = $movimentopacController->RetornarMesAP($ativopassivo22, $mes_filtro_cat, $ano_filtro_cat);
} else {
    $ativopassivo22 = 1;
    $ListaMesAP = $movimentopacController->RetornarMesAP(1, $mes_hoje, $ano_hoje);
}
//var_dump($ListaMesAP);
//FINANCEIRO PLANO DE SAUDE FIM
?>


<style>
    #eusouomestre:hover{
        color:#fff;
    }
</style>
<link href="Interface/Bootstrap/responsividade.css" rel="stylesheet" type="text/css"/>
<div class="card">
    <div class="card-body">
        <h2>Livro Caixa</h2>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6 col-md-6">
                        <label for="txtTipopag" class="control-label">Mês:</label>
                        <select style="padding:15px; font-size:16pt; width: 100%;" onchange="location.replace('?pagina=financeiro&mes=' + this.value + '&ano=<?= $ano_hoje; ?><?php
                        if (isset($_GET['empresa'])) {
                            echo "&empresa";
                        }
                        ?>')">
                                    <?php
                                    for ($i = 1; $i <= 12; $i++) {
                                        ?>
                                <option style="padding:15px; font-size:12pt;" value="<?php echo $i ?>" <?php if ($i == $mes_hoje) echo "selected=selected" ?> >  <?php echo mostraMes($i); ?></option>
                                <?php
                            }
                            ?>
                        </select> 
                    </div>
                    <div class="col-6 col-md-6">
                        <label for="txtTipopag" class="control-label">Ano:</label>
                        <select style="padding:15px; font-size:16pt; width: 100%;" onchange="location.replace('?pagina=financeiro<?php
                        if (isset($_GET['empresa'])) {
                            echo "&empresa";
                        }
                        ?>&mes=<?php echo $mes_hoje ?>&ano=' + this.value)">
                                    <?php
                                    for ($i = 2015; $i <= 2025; $i++) {
                                        ?>
                                <option style="padding:15px; font-size:12pt;" value="<?php echo $i ?>" <?php if ($i == $ano_hoje) echo "selected=selected" ?> ><?php echo $i ?></option>
                            <?php } ?>
                        </select> 
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div>
        <a target="_blank" href="Impressoes/Imprimir.php?pagina=1&dia=<?= $dia_hoje; ?>&mes=<?= $mes_hoje; ?>&ano=<?= $ano_hoje; ?>" style="color:#000; margin:5px;" class="btn btn-outline-secondary badge-pill" ><strong class = "d-block text-gray-dark" style="font-size: 10pt;">Balanço Mensal</strong></a>
        <a href="" style="color:#000; margin:5px;" class="btn btn-outline-secondary badge-pill" ><strong class = "d-block text-gray-dark" style="font-size: 10pt;">Balanço Anual</strong></a>

    </div>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link <?php if (!isset($_GET['empresa'])) { ?> active <?php } ?>" href="?pagina=financeiro&dia=<?= $dia_hoje; ?>&mes=<?= $mes_hoje; ?>&ano=<?= $ano_hoje; ?>">Clientes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if (isset($_GET['empresa'])) { ?> active <?php } ?> " href="?pagina=financeiro&dia=<?= $dia_hoje; ?>&mes=<?= $mes_hoje; ?>&ano=<?= $ano_hoje; ?>&empresa">Empresa</a>
        </li>
    </ul>
    <?php
    if (!isset($_GET['empresa'])) {

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
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-12 col-md-6">
                        <div class="card mb-4 box-shadow">
                            <div class="card-header" style="background-color: #00bbff;">
                                <h4 class="my-0 font-weight-normal" style="color:#fff">Faturamento Mensal</h4>
                            </div>
                            <div class="card-body" style="text-align: center;">
                                <ul class="list-unstyled mt-12 mb-12">
                                    <li style="color: green;">Recebido: R$ <?= number_format($totalfinalmestipo1, 2, ',', '.') ?></li>
                                    <li style="color: red;">A receber: R$ <?= number_format($totalfinalmestipo2, 2, ',', '.') ?></li>
                                    <li>-----------------------------------</li>
                                </ul>
                                <h5 style="color: blue;" class="my-0 font-weight-normal"><b>R$ <?= number_format($totalfinalmes, 2, ',', '.') ?></b></h5>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card mb-4 box-shadow">
                            <div class="card-header" style="background-color: #9acfea;">
                                <h4 class="my-0 font-weight-normal" style="color:#fff">Faturamento Anual</h4>
                            </div>
                            <div class="card-body" style="text-align: center;"> 
                                <ul class="list-unstyled mt-12 mb-12">
                                    <li style="color:green;">Recebido: R$ <?= number_format($totalfinalanotipo1, 2, ',', '.') ?></li>
                                    <li style="color:red;">A Receber: R$ <?= number_format($totalfinalanotipo2, 2, ',', '.') ?></li>
                                    <li>-----------------------------------</li>
                                </ul>
                                <h5 style="color:blue;" class="my-0 font-weight-normal"><b>R$ <?= number_format($totalfinalano, 2, ',', '.') ?></b></h5>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <form name="form_filtro_cat" method="post" action="" style="text-align: left;">
                <div class="row">
                    <div class="col-12 col-md-12" >
                        <div class="form-group label-floating">
                            <label for="" class="control-label">Filtrar por Tipo</label>            
                            <select name="filtro_cat" id='filtro_cat'  class="form-control">
                                <option value="1">Recebido</option>
                                <option value="2">a Receber</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12" >           
                        <input type="hidden" name="pagina" value="financeiro">
                        <input type="hidden" name="dia" value="<?php echo $dia_hoje ?>" >
                        <input type="hidden" name="mes" value="<?php echo $mes_hoje ?>" >
                        <input type="hidden" name="ano" value="<?php echo $ano_hoje ?>" >
                        <label for="btnEnviarCli" class="control-label">.</label> 
                        <input type="submit" value="Filtrar" class="btn btn-default" name="btnEnviarTipo" id="btnEnviarTipo" />
                    </div>
                </div>
            </form>
            <br>
        </div>

        <div class = "card">
            <div class = "card-body">
                <table class="table table-bordered">
                    <thead class="thead-dark">
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
                    if ($ListaMesAP != null) {
                        foreach ($ListaMesAP as $movtipo) {
                            $cont22++;
                            $pontos = ',';
                            $result = str_replace($pontos, "", $movtipo->getTotal());
                            $valor_total = (float) $result;
                            $totaldomes = $totaldomes + $valor_total;
                            $cod_paciente22 = 0;
                            $Funcionario = 0;
                            $ListaBuscaOrcamento = [];
                            $movtipo->getCod_orcamento();
                            $ListaBuscaOrcamento = $orcamentoController->RetornarOrcamentos(2, $movtipo->getCod_orcamento());
                            if ($ListaBuscaOrcamento != null) {
                                foreach ($ListaBuscaOrcamento as $orc) {
                                    $cod_paciente22 = $orc->getUsuario();
                                    $Funcionario = $orc->getFunc();
                                }
                            }
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

            </div>
        </div>
        <?php
    }
    if (isset($_GET['empresa'])) {
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
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <a class="btn btn-outline-primary badge-pill" id="eusouomestre"  role="button" data-toggle="modal" data-target="#exampleModal3">Adicionar novo movimento</a>
                    <a class="btn btn-outline-warning badge-pill" id="eusouomestre"  role="button" data-toggle="modal" data-target="#exampleModal4">Adicionar nova Categoria</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-12 col-md-6">
                        <div class="card mb-4 box-shadow">
                            <div class="card-header" style="background-color: #ff8f5e;">
                                <h4 class="my-0 font-weight-normal" style="color:#fff">Despesa Mensal</h4>
                            </div>
                            <div class="card-body" style="text-align: center;">
                                <h5 class="my-0 font-weight-normal"><b>R$ <?= number_format($totalfinalmes, 2, ',', '.') ?></b></h5>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card mb-4 box-shadow">
                            <div class="card-header" style="background-color: #EB5E28;">
                                <h4 class="my-0 font-weight-normal" style="color:#fff">Despesa Anual</h4>
                            </div>
                            <div class="card-body" style="text-align: center;"> 
                                <h5 class="my-0 font-weight-normal"><b>R$ <?= number_format($totalfinalano, 2, ',', '.') ?></b></h5>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-12">
            <form name="form_filtro_cat" method="post" action="" style="text-align: left;">
                <div class="row">
                    <div class="col-12 col-md-12" >
                        <div class="form-group label-floating">
                            <label for="" class="control-label">Filtrar por categoria</label>            
                            <select name="filtro_cat"  class="form-control">
                                <?php
                                if ($ListaCategoriass != null) {
                                    foreach ($ListaCategoriass as $FinanceiroCategorias) {
                                        ?>
                                        <option value="<?= $FinanceiroCategorias->getId(); ?>"><?= $FinanceiroCategorias->getNome(); ?></option>         
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12" >           
                        <input type="hidden" name="pagina" value="financeiro">
                        <input type="hidden" name="dia" value="<?php echo $dia_hoje ?>" >
                        <input type="hidden" name="mes" value="<?php echo $mes_hoje ?>" >
                        <input type="hidden" name="ano" value="<?php echo $ano_hoje ?>" >
                        <label for="btnEnviar" class="control-label">.</label> 
                        <input type="submit" value="Filtrar" class="btn btn-default" name="btnEnviar" id="btnEnviar" />
                    </div>
                </div>
            </form>
            <br>
        </div>
        <div class = "card">
            <div class = "card-body">
                <div class="row" style="margin-top: 10px;">
                    <div class="col-12 col-md-12">
                        <table class="table table-bordered" style="text-align: center;">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col"  style="text-align: center;">nº</th>
                                    <th scope="col"  style="text-align: center;">Descrição</th>
                                    <th scope="col"  style="text-align: center;">Categoria</th>
                                    <th scope="col"  style="text-align: center;">Valor</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $totalfinal = 0;
                                if ($listamovimentosPorMes != null) {
                                    foreach ($listamovimentosPorMes as $despesas) {
                                        $total = 0;
                                        $pontos = ',';
                                        $result = str_replace($pontos, "", $despesas->getValor());
                                        $valor_total = (float) $result;
                                        $total = $valor_total;
                                        $totalfinal = $totalfinal + $total;
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $despesas->getId(); ?>
                                            </td>
                                            <td>
                                                <?= $despesas->getDescricao(); ?>
                                            </td>
                                            <td>
                                                <?= $CategoriaFinanceiroController->RetornarNomeCat($despesas->getCat()); ?>
                                            </td>
                                            <td>
                                                R$ <?= number_format($total, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                <tr>
                                    <td colspan="3" style="text-align: right"><b>Total Final</b></td>
                                    <td><b>R$ <?= number_format($totalfinal, 2, ',', '.') ?></b></td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
        <?php
    }
    ?>
</div>

<!-- Modal Despesa -->
<div class="modal fade bd-example-modal-lg" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Adicionar Movimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:left;"  >
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label for="txtData" class="control-label">Data</label>
                                <input  type="text" class="form-control" id="txtData" name="txtData" value="<?= date('d') . '/' . $mes_hoje . '/' . $ano_hoje; ?>">
                            </div>
                        </div>
                        <input name="txtTipo" id="txtTipo" value="0" type="hidden"/>
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label for="txtCat" class="control-label">Categorias</label>            
                                <select  name="txtCat"  class="form-control" id="txtCat" >

                                    <?php
                                    if ($ListaCategoriass != null) {
                                        foreach ($ListaCategoriass as $FinanceiroCategorias) {
                                            ?>
                                            <option value="<?= $FinanceiroCategorias->getId(); ?>"><?= $FinanceiroCategorias->getNome(); ?></option>         
                                            <?php
                                        }
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label for="txtTipo" class="control-label">Descrição</label>            
                                <input  type="txt" class="form-control" id="txtDescricao" name="txtDescricao" value="" >

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group label-floating">
                                <label for="txtValor" class="control-label" style="text-align:left;">Valor</label>            
                                <input  type="txt" name="txtValor" id="txtValor" class="form-control" value="" >
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-lg" data-dismiss="modal">Close</button>
                        <input  type="submit" value="Cadastrar Movimento" class="btn btn-outline-dark btn-lg" name="btnCadastrar" />

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Categoria -->
<div class="modal fade bd-example-modal-lg" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel4">Adicionar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:left;"  >
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group label-floating">
                                <label for="txtDescricao" class="control-label">Descrição</label>            
                                <input  type="txt" class="form-control" id="txtDescricao" name="txtDescricao" value="" >
                            </div>
                        </div>


                        <div class="col-sm-12" style="text-align:center;">


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-lg" data-dismiss="modal">Close</button>
                        <input  type="submit" value="Cadastrar Categoria" class="btn btn-outline-warning btn-lg" name="btnCadastrarCategoria" />

                    </div>
                </form>
                <table class="table table-bordered" style="">    
                    <tr>
                        <td colspan="2">Nome Categoria</td>
                        <td colspan="2">#</td>
                    </tr>
                    <?php
                    if ($ListaCategoriass != null) {
                        foreach ($ListaCategoriass as $FinanceiroCategorias) {
                            ?>

                            <tr>
                                <td colspan="2" style="text-align: left;">
                                    <a style="width: 100%;" class="btn btn-outline-info btn-lg"><?= $FinanceiroCategorias->getNome(); ?></a>

                                </td>
                                <td colspan="2" style="text-align: right;">
                                    <form name="form_cadastrarmovimento" method="post" action="" style="text-align:right;"  >
                                        <input  type="hidden"  id="txtCod" name="txtCod" value=" <?= $FinanceiroCategorias->getId(); ?>" >
                                        <input style="width: 100%;"  type="submit" value="Apagar" class="btn btn-outline-warning btn-lg" name="btnCadastrarCategoriaApagar" />
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>

            </div>
        </div>
    </div>
</div>

