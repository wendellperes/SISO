<?php
require_once("../Controller/ProdutosController.php");
require_once("../Model/Produtos.php");
require_once ("../Controller/CategoriasController.php");
require_once ("../Model/Categorias.php");
require_once ("../Controller/FornecedoresController.php");
require_once ("../Model/Fornecedores.php");
require_once ("../Controller/EntradasController.php");
require_once ("../Model/Entradas.php");
require_once ("../Controller/SaidasController.php");
require_once ("../Model/Saidas.php");
require_once ("../Controller/ListaEntradasController.php");
require_once ("../Model/ListaEntradas.php");
require_once ("../Controller/ListaSaidasController.php");
require_once ("../Model/ListaSaidas.php");
require_once ("../Controller/FuncionariosController.php");
require_once ("../Model/Funcionarios.php");
require_once ("../Controller/OrgaosController.php");
require_once ("../Model/Orgaos.php");
require_once ("../Controller/SolicitacoesController.php");
require_once ("../Model/Solicitacoes.php");


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



$produtosController = new ProdutosController();
$categoriasController = new CategoriasController();
$fornecedoresController = new FornecedoresController();
$entradasController = new EntradasController();
$listaentradasControler = new ListaEntradasController();
$funcionariosController = new FuncionariosController();
$orgaosController = new OrgaosController();
$saidasController = new SaidasController();
$listasaidasControler = new ListaSaidasController();
$solicitacoesController = new SolicitacoesController();

$apresentacao = 0;
$descricao = "";
$qtd = 0;
$valor = "";
$est_mim = 0;
$est_max = 0;
$tipo = 0;
$status = 0;
$categoria = 0;
$fornecedor = 0;
$img = "";
$cod_orgaoFg = (int) $_SESSION['cod_orgaoF'];
$descricaofor = "";
$cnpjfor = "";
$enderecofor = "";
$telefonefor = "";
$n_notafiscal = "";
$cod_produto = 0;
$cod_funcionario = 0;
$nomecategoria = "";


$cod_entrada = 0;
$lote = "";
$mes_validade = "";
$ano_validade = "";
$qtd = 1;
$validade = "";
$valor_total = "";

$ListaCategorias = [];

$resultado = "";
$erros = [];

$cod_orgaoF = $_SESSION['cod_orgaoF'];
$ListaCategorias = $categoriasController->RetornarCategorias($cod_orgaoF);
?>

<div class="row">
    <div class="col-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-light table-bordered">
                    <tr>
                        <td></td>
                        <th colspan="3" style="text-align: center;">
                            <h1>Secretária Municipal de Saúde</h1>
                            <h3>Relátorio Diário - <?= $dia_hoje; ?>/<?= $mes_hoje; ?>/<?= $ano_hoje; ?></h3>
                        </th>
                        <td></td>
                    </tr>
                </table>
                <table class="table table-light table-bordered">
                    <tr>
                        <td colspan="5" style="text-align: center;"><h4>Entradas - Resumo</h4></td>
                    </tr>    
                    <tr>
                        <th>Nota Fiscal</th>
                        <th>Data</th>
                        <th>Conferidores</th>
                        <th>Qtd Total de Produtos</th>
                        <th>Valor Total em Produtos</th>
                    </tr>
                    <?php
                    $TOTALENTRADASVALOR = 0;
                    $TOTALENTRADASQTD = 0;
                    $ListaEntradasMensal = [];
                    $ListaListaEntradasMensal = [];
                    $ListaEntradasMensal = $entradasController->RetornarEntradasDiaMesAno($dia_hoje, $mes_hoje, $ano_hoje, $cod_orgaoF, 1);

                        if ($ListaEntradasMensal != NULL) {
                        foreach ($ListaEntradasMensal as $entradas3) {
                            ?>
                            <tr>
                                <td><?= $entradas3->getN_notafiscal(); ?></td>
                                <td><?= $entradas3->getDia(); ?>/<?= $entradas3->getMes(); ?>/<?= $entradas3->getAno(); ?></td>
                                <td><?= $entradas3->getConferidor1(); ?> - <?= $entradas3->getConferidor2(); ?> - <?= $entradas3->getConferidor3(); ?></td>
                                <?PHP
                                $ListaListaEntradasMensal = $listaentradasControler->RetornarListaEntradas("", 1, $entradas3->getCod());
                                //var_dump($ListaListaEntradasMensal);
                                $qtdfinal = 0;
                                $valorfinal = 0;
                                if ($ListaListaEntradasMensal != NULL) {
                                    foreach ($ListaListaEntradasMensal as $entradas4) {
                                        $qtdfinal = $qtdfinal + $entradas4->getQtd();
                                        $pontos = ',';
                                        $result = str_replace($pontos, "", $entradas4->getValor_total());
                                        $valor = (float) $result;
                                        $valorfinal = $valorfinal + $valor;

                                        $TOTALENTRADASVALOR = $TOTALENTRADASVALOR + $valor;
                                        $TOTALENTRADASQTD = $TOTALENTRADASQTD + $entradas4->getQtd();
                                    }
                                }
                                ?>
                                <td><?= $qtdfinal; ?></td>
                                <td>R$ <?= number_format($valorfinal, 2, ',', '.'); ?></td>
                            </tr>
                            <?php
                            $qtdfinal = 0;
                            $valorfinal = 0;
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="3" style="text-align: right;"><b>Totais do Mês:</b></td>
                        <td><?= $TOTALENTRADASQTD; ?></td>
                        <td>R$ <?= number_format($TOTALENTRADASVALOR, 2, ',', '.'); ?></td>
                    </tr>
                </table>
                <table class="table table-light table-bordered">
                    <tr>
                        <td colspan="4" style="text-align: center;"><h4>Saídas - Resumo</h4></td>
                    </tr>    
                    <tr>
                        <th>Destinátario</th>
                        <th>Funcionário</th>
                        <th>Data</th>
                        <th>Qtd Total</th>
                    </tr>
                    <?php
                    $TOTALSAIDASQTD = 0;
                    $ListaListaSaidasMensal = [];
                    $ListaSaidasMensal = [];
                    $ListaSaidasMensal = $saidasController->RetornarSaidasDiaMesAno($dia_hoje, $mes_hoje, $ano_hoje, $cod_orgaoF, 1);
                    if ($ListaSaidasMensal != NULL) {
                        foreach ($ListaSaidasMensal as $saidas3) {
                            ?>
                            <tr>
                                <td><?= $orgaosController->RetornarNomeOrgaos($saidas3->getCod_destinatario()) ?></td>
                                <td><?= $funcionariosController->RetornarNomeFuncionarios($saidas3->getCod_funcionario()); ?></td>
                                <td><?= $saidas3->getDia(); ?>/<?= $saidas3->getMes(); ?>/<?= $saidas3->getAno(); ?></td>
                                <?php
                                $qtdfinal = 0;
                                $ListaListaSaidasMensal = $listasaidasControler->RetornarListaSaidas("", 1, $saidas3->getCod());
                                if ($ListaListaSaidasMensal != NULL) {
                                    foreach ($ListaListaSaidasMensal as $saidas4) {
                                        $qtdfinal = $qtdfinal + $saidas4->getQtd();
                                        $TOTALSAIDASQTD = $TOTALSAIDASQTD + $saidas4->getQtd();
                                    }
                                }
                                ?>
                                <td><?= $qtdfinal; ?></td>
                            </tr>
                            <?php
                            $qtdfinal = 0;
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="3" style="text-align: right;"><b>Total do Mês:</b></td>
                        <td><?= $TOTALSAIDASQTD ?></td>
                    </tr>
                </table>
                <table class="table table-light table-bordered">
                    <tr>
                        <td colspan="5" style="text-align: center;"><h4>Solicitações - Resumo</h4></td>
                    </tr>    
                    <tr>
                        <th>Cod Solicitação</th>
                        <th>Produto</th>
                        <th>Qtd</th>
                        <th>Data</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    $TOTALSOLICITACOESQTD = 0;
                    $ListasolicitacoesMensal = [];
                    $ListasolicitacoesMensal = $solicitacoesController->RetornarSolicitacoesDiaMesAno($dia_hoje, $mes_hoje, $ano_hoje, $cod_orgaoF, 1);
                    if ($ListasolicitacoesMensal != NULL) {
                        foreach ($ListasolicitacoesMensal as $solicitacoes3) {
                            ?>
                            <tr>
                                <td><?= $solicitacoes3->getCod(); ?></td>
                                <td><?= $produtosController->RetornarNomeProdutos($solicitacoes3->getCod_produto()) ?></td>
                                <td><?= $solicitacoes3->getQtd(); ?></td>
                                <td><?= $solicitacoes3->getDia(); ?>/<?= $solicitacoes3->getMes(); ?>/<?= $solicitacoes3->getAno(); ?></td>
                                <?php
                                if ($solicitacoes3->getStatus() == 1) {
                                    $textoStatus = "a Receber";
                                } else if ($solicitacoes3->getStatus() == 2) {
                                    $textoStatus = "Recebido";
                                }
                                $TOTALSOLICITACOESQTD = $TOTALSOLICITACOESQTD + $solicitacoes3->getQtd();
                                ?>
                                <td><?= $textoStatus ?></td>
                            </tr>
                            <?php
                            $qtdfinal = 0;
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="4" style="text-align: right;"><b>Total do Mês:</b></td>
                        <td><?= $TOTALSOLICITACOESQTD ?></td>
                    </tr>
                </table>
                <?php
                $nomeF = $_SESSION['nomeF'];
                $funcaoF = $_SESSION['funcaoF'];
                ?>
                <table class="table table-light table-bordered">
                    <tr>
                        <td style="text-align: center;"></br></br>
                            __________________________________________________________________________</br>
                            <?= $nomeF; ?></br>
                            <?= $funcaoF; ?></br>
                        </td>
                    </tr>    
                </table>
                <table class="table table-light table-bordered">
                    <tr>
                        <th colspan="4" style="text-align: right;">Data de Expedição: </th><td ><?= date('d/m/Y h:i:s'); ?></td>
                    </tr>    
                </table>
            </div>
        </div>
    </div>
</div>


