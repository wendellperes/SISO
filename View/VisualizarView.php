<?php
require_once("Model/Paciente.php");
require_once("Model/Anamnese.php");
require_once("Model/Orcamento.php");
require_once("Model/Procedimento.php");
require_once("Model/Pagamento.php");
require_once("Model/PagParPro.php");
require_once ("Model/Listaespera.php");
require_once ("Model/Dente.php");
require_once ("Model/Servico.php");
require_once ("Model/AtivoPassivo.php");
require_once ("Model/Usuario.php");
require_once("Util/functions.php");

require_once("Controller/MovimentoPacController.php");
require_once("Controller/PacienteController.php");
require_once("Controller/AnamneseController.php");
require_once("Controller/OrcamentoController.php");
require_once("Controller/ProcedimentoController.php");
require_once("Controller/PagamentoController.php");
require_once("Controller/PagParProController.php");
require_once("Controller/ListaEsperaController.php");
require_once("Controller/DenteController.php");
require_once("Controller/ServicoController.php");
require_once("Controller/UsuarioController.php");


$pacienteController = new PacienteController();
$anamneseController = new AnamneseController();
$orcamentoController = new OrcamentoController();
$pagamentoController = new PagamentoController();
$pagparproController = new PagParProController();
$procedimentoController = new ProcedimentoController();
$denteController = new DenteController();
$servicoController = new ServicoController();
$listaesperaController = new ListaesperaController();
$movimentopacController = new MovimentoPacController();
$usuarioController = new UsuarioController();


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

$erros = [];


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
$totalapagar = 0;

$listaPacientesBusca = [];
$listaAnamnesesBusca = [];
$listaOrcamentos = [];
$listaPagamentos = [];
$listaPagParPro = [];
$listaOrcamentosMes = [];
$listaOrcamentosTodas = [];
$listamovimentosatraso = [];

$id = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
$tipo = 1;

$listaOrcamentos = $orcamentoController->RetornarOrcamentos($tipo, $id);

$mes = date('m');
$ano = date('Y');
$listaOrcamentosMes = $orcamentoController->RetornarOrcamentosConsulta($tipo, $id, $mes, $ano);

$cod_cadastrador = $_SESSION['codF'];

if (filter_input(INPUT_POST, "bntGerarBoletos", FILTER_SANITIZE_STRING)) {

    $i = 1;
    $diaatual = filter_input(INPUT_POST, "txtDiaAtual", FILTER_SANITIZE_NUMBER_INT);;
    $mesatual = filter_input(INPUT_POST, "txtMesAtual", FILTER_SANITIZE_NUMBER_INT);;
    $anoatual = filter_input(INPUT_POST, "txtAnoAtual", FILTER_SANITIZE_NUMBER_INT);;

    $cod_usu = filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT);
    $tipo_movimento = 2;
    $subtotal = "70.00";
    $total = "70.00";
    $numparcelas = 1;
    $tipopag = "Boleto";
    $categoria = 0;
    $dia = date('d');
    do {

        $descricao = "PAGAMENTO REFERENTE A PARCELA DO MÊS DE: " . mostraMes($mesatual) . "/" . $anoatual;


        $movimentopac = new MovimentoPac();
        $movimentopac->setCod_orcamento($cod_usu);
        $movimentopac->setTipo($tipo_movimento);
        $movimentopac->setSubtotal($subtotal);
        $movimentopac->setTotal($total);
        $movimentopac->setDescricao($descricao);
        $movimentopac->setNumparcelas($numparcelas);
        $movimentopac->setTipopag($tipopag);
        $movimentopac->setCategoria($categoria);
        $movimentopac->setDia($diaatual);
        $movimentopac->setMes($mesatual);
        $movimentopac->setAno($anoatual);


        if ($movimentopacController->Cadastrar($movimentopac)) {
            $resultado = " <div class='alert alert-success' role='alert'><span>Vínculo gerado com sucesso!</span> </div>";
        } else {
            $resultado = " <div class='alert alert-danger' role='alert'><span>>Erro ao cadastrar movimento <a href='painel.php?pagina=financeiropac'>Clique aqui e tente novaimmente. </a></span> </div>";
        }

        if ($mesatual >= 12) {
            $mesatual = $mesatual - 12;
            $anoatual = $anoatual + 1;
        }
        $mesatual++;
        $i++;
    } while ($i <= 12);
}
if (filter_input(INPUT_POST, "btnCadastrarAnamnese", FILTER_SANITIZE_STRING)) {

//   $erros = Validar();

    $cod_usu = filter_input(INPUT_POST, "txtCodUsu", FILTER_SANITIZE_STRING);
    $dentista_antes = filter_input(INPUT_POST, "txtDentista1", FILTER_SANITIZE_STRING);
    $reacao_anestesia = filter_input(INPUT_POST, "txtReacao", FILTER_SANITIZE_STRING);
    $como = filter_input(INPUT_POST, "txtComo", FILTER_SANITIZE_STRING);
    $alergia_medicamento = filter_input(INPUT_POST, "txtAlergiaMedicamento", FILTER_SANITIZE_STRING);
    $qual = filter_input(INPUT_POST, "txtQual", FILTER_SANITIZE_STRING);
    $outras_alergias = filter_input(INPUT_POST, "txtOutrasAlergias", FILTER_SANITIZE_STRING);
    $outra_doenca = filter_input(INPUT_POST, "txtOutradoenca", FILTER_SANITIZE_STRING);
    $doenca_familia = filter_input(INPUT_POST, "txtDoencasfamilias", FILTER_SANITIZE_STRING);
    $medicamento = filter_input(INPUT_POST, "txtMedicamento", FILTER_SANITIZE_STRING);
    $data2 = date('Y-m-d');


    $doencas = "";

    if (isset($_POST['Diabets'])) {
        $doencas = $doencas . "Diabets  - ";
    }
    if (isset($_POST['Hipertensao'])) {
        $doencas = $doencas . "Hipertensão  - ";
    }
    if (isset($_POST['HIV'])) {
        $doencas = $doencas . "HIV  - ";
    }
    if (isset($_POST['Hepatite'])) {
        $doencas = $doencas . "Hepatite  - ";
    }
    if (isset($_POST['ProblemasRenais'])) {
        $doencas = $doencas . "Problemas Renais  - ";
    }
    if (isset($_POST['ProblemasPulmonares'])) {
        $doencas = $doencas . " Problemas Pulmonares";
    }



//   if (empty($erros)) {

    $anamnese = new Anamnese();

    $anamnese->setCod_usu($cod_usu);
    $anamnese->setDentista_antes($dentista_antes);
    $anamnese->setReacao_anestesia($reacao_anestesia);
    $anamnese->setComo($como);
    $anamnese->setAlergia_medicamento($alergia_medicamento);
    $anamnese->setQual($qual);
    $anamnese->setOutras_alergia($outras_alergias);
    $anamnese->setDoencas($doencas);
    $anamnese->setOutra_doenca($outra_doenca);
    $anamnese->setDoenca_familia($doenca_familia);
    $anamnese->setMedicamento($medicamento);
    $anamnese->setData($data2);

    if ($anamneseController->Cadastrar($anamnese)) {

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
        $data = "";
        $resultado = "";

        $resultado = " <div class='alert alert-success' role='alert'><span>Anamnese cadastrado com sucesso!</span> </div>";
    } else {

        $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um erro ao cadastrar Anamnese!</span> </div>";
    }

//Editar
// $paciente->setId(filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT));
//  if ($pacienteController->Alterar($paciente)) {
//         $resultado = " <div class='alert alert-success' role='alert'><span>Dados do paciente alterado com sucesso!</span> </div>";
//    } else {
//         $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um erro ao alterar dados do paciente!</span> </div>";
//     }
//}
}
if (filter_input(INPUT_POST, "btnCadastrarOrca", FILTER_SANITIZE_STRING)) {
    $status = 1;
    $usuario1 = $id;

    $data_hoje2 = date('d/m/Y');

    $t = explode("/", $data_hoje2);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];


    $orcamento = new Orcamento();
    $orcamento->setStatus($status);
    $orcamento->setUsuario($usuario1);
    $orcamento->setDia($dia);
    $orcamento->setMes($mes);
    $orcamento->setAno($ano);
    $orcamento->setFunc($cod_cadastrador);

    if ($orcamentoController->Cadastrar($orcamento)) {
        $resultado = " <div class='alert alert-success' role='alert'><span>Orçamento cadastrado com sucesso!</span> </div>";
        header("location: painel.php?pagina=consulta");
    } else {
        $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um herro ao cadastrar novo Orçamento!</span> </div>";
    }
}
if (filter_input(INPUT_POST, "btnCancelarOr", FILTER_SANITIZE_STRING)) {

    $cod = filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT);

    $orcamentoController->Deletar($cod);
    $procedimentoController->DeletarO($cod);
}
if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
    $termo = "";
    $status = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
    $tipo = 2;
    $listaPacientesBusca = $pacienteController->RetornarPacientes($termo, $tipo, $status);
//var_dump($listaPacientesBusca);
}
if (filter_input(INPUT_GET, "cod_lista", FILTER_SANITIZE_NUMBER_INT)) {
    $cod_lista = filter_input(INPUT_GET, "cod_lista", FILTER_SANITIZE_NUMBER_INT);
    $cod_pac = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);

    $apagareventolist = $listaesperaController->DeletarEspera($cod_lista);
    header("location: painel.php?pagina=visualizar&cod=$cod_pac");
//var_dump($listaPacientesBusca);
}
if (filter_input(INPUT_POST, "btnCadastrar", FILTER_SANITIZE_STRING)) {
    $cod_pac = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
    $data = date('d/m/Y h:i:s');
    $listaespera = new Listaespera();
    $listaespera->setCod_paciente($cod_pac);
    $listaespera->setData($data);
    if ($listaesperaController->Cadastrar($listaespera)) {

        header('Location: painel.php');
    } else {
        $resultado = "Houve um erro ao cadastrar";
    }
}
if (filter_input(INPUT_POST, "btnPagarParcela", FILTER_SANITIZE_STRING)) {
    $cod = filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT);

    $movimentopacController->Pagar(1, $cod);

    header("location: painel.php?pagina=visualizar&cod=" . $_GET['cod'] . "&outros");
    $resultado = "Parcela paga com sucesso";
}
if (filter_input(INPUT_POST, "btnTrocaStatus", FILTER_SANITIZE_STRING)) {
    $cod = filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT);

    $pacienteController->AlterarIna(2, $cod);
    header("location: painel.php?pagina=visualizar&cod=" . $_GET['cod'] . "&outros");
    $resultado = "Status Alterado com sucesso";
}
if (filter_input(INPUT_POST, "btnTrocaStatusH", FILTER_SANITIZE_STRING)) {
    $cod = filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT);
    $pacienteController->AlterarIna(1, $cod);
    // header("location: painel.php?pagina=visualizar&cod=" . $cod . "&outros");
    // $resultado = "Status Alterado com sucesso";
}
if (filter_input(INPUT_POST, "btnFecharContrato", FILTER_SANITIZE_STRING)) {
    $cod = filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT);
    $pacienteController->AlterarIna(3, $cod);

    $listamovimentoapagar = $movimentopacController->RetornarPac($cod, 2);
    //var_dump($listamovimentosatraso);
    $totalapagar = "609.00";

    $movimentopacController->DeletarPagamentos($cod);
    $nomepac = $pacienteController->RetornarNomePac($cod);

    $descricao = $nomepac;
    $tipopag = "Dinheiro";
    $dia = date('d');
    $mes = date('m');
    $ano = date('Y');

    $movimentopac = new MovimentoPac();
    $movimentopac->setCod_orcamento(0);
    $movimentopac->setTipo(1);
    $movimentopac->setSubtotal($totalapagar);
    $movimentopac->setTotal($totalapagar);
    $movimentopac->setDescricao($descricao);
    $movimentopac->setNumparcelas(1);
    $movimentopac->setTipopag($tipopag);
    $movimentopac->setCategoria(0);
    $movimentopac->setDia($dia);
    $movimentopac->setMes($mes);
    $movimentopac->setAno($ano);


    if ($movimentopacController->Cadastrar($movimentopac)) {
        $resultado = " <div class='alert alert-success' role='alert'><span>Contrato fechado com sucesso!</span> </div>";
    } else {
        $resultado = " <div class='alert alert-danger' role='alert'><span>>Erro ao fechar Contrato <a href='painel.php?pagina=financeiropac'>Clique aqui e tente novaimmente. </a></span> </div>";
    }
    //header("location: painel.php?pagina=visualizar&cod=" . $_GET['cod']);
    $resultado = " <div class='alert alert-success' role='alert'><span>Contrato fechado com sucesso!</span> </div>";
}


if (filter_input(INPUT_POST, "btnSubmitEd", FILTER_SANITIZE_STRING)) {

    $nome = filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING);
    $datacadastro = filter_input(INPUT_POST, "txtDataCadastro", FILTER_SANITIZE_STRING);
    $nascimento = filter_input(INPUT_POST, "txtNascimento", FILTER_SANITIZE_STRING);
    $rg = filter_input(INPUT_POST, "txtRg", FILTER_SANITIZE_STRING);
    $cpf = filter_input(INPUT_POST, "txtCpf", FILTER_SANITIZE_STRING);
    $endereco = filter_input(INPUT_POST, "txtRua", FILTER_SANITIZE_STRING);
    $numero = filter_input(INPUT_POST, "txtNumero", FILTER_SANITIZE_STRING);
    $complemento = filter_input(INPUT_POST, "txtComplemento", FILTER_SANITIZE_STRING);
    $celular = filter_input(INPUT_POST, "txtCelular", FILTER_SANITIZE_STRING);
    $residencial = filter_input(INPUT_POST, "txtResidencial", FILTER_SANITIZE_STRING);
    $responsavel = filter_input(INPUT_POST, "txtResponsavel", FILTER_SANITIZE_STRING);
    $indicacao = filter_input(INPUT_POST, "txtIndicacao", FILTER_SANITIZE_STRING);
    $datacadastro = filter_input(INPUT_POST, "txtData", FILTER_SANITIZE_STRING);
    $dr = filter_input(INPUT_POST, "txtDr", FILTER_SANITIZE_STRING);


    if (empty($erros)) {

        $paciente = new Paciente();

        $paciente->setNome(filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING));
        $paciente->setNascimento(filter_input(INPUT_POST, "txtNascimento", FILTER_SANITIZE_STRING));
        $paciente->setRg(filter_input(INPUT_POST, "txtRg", FILTER_SANITIZE_STRING));
        $paciente->setCpf(filter_input(INPUT_POST, "txtCpf", FILTER_SANITIZE_STRING));
        $paciente->setEndereco(filter_input(INPUT_POST, "txtRua", FILTER_SANITIZE_STRING));
        $paciente->setNumero(filter_input(INPUT_POST, "txtNumero", FILTER_SANITIZE_STRING));
        $paciente->setComplemento(filter_input(INPUT_POST, "txtComplemento", FILTER_SANITIZE_STRING));
        $paciente->setCelular(filter_input(INPUT_POST, "txtCelular", FILTER_SANITIZE_STRING));
        $paciente->setResidencial(filter_input(INPUT_POST, "txtResidencial", FILTER_SANITIZE_STRING));
        $paciente->setResponsavel(filter_input(INPUT_POST, "txtResponsavel", FILTER_SANITIZE_STRING));
        $paciente->setIndicacao(filter_input(INPUT_POST, "txtIndicacao", FILTER_SANITIZE_STRING));
        $paciente->setData($datacadastro);
        $paciente->setStatus(filter_input(INPUT_POST, "txtStatus", FILTER_SANITIZE_STRING));
        $paciente->setDr($dr);

        $paciente->setId(filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT));
        $cod = $_GET['cod'];
        $tipo = 2;

        if ($pacienteController->Alterar($paciente)) {
            header("location: painel.php?pagina=visualizar&cod=$cod");
            $resultado = " <div class='alert alert-success' role='alert'><span>Dados do paciente alterado com sucesso!</span> <a href='?pagina=visualizar&cod=$cod'> Clique aqui para Visualizar Dados</a> </div>";
        } else {
            $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um erro ao alterar dados do paciente!</span> </div>";
        }
    }
}


if ($listaPacientesBusca != null) {
    foreach ($listaPacientesBusca as $user) {
        $cod_pacH = $user->getId();
        $diaatual = date('d');
        $mesatual = date('m');
        $anoatual = date('Y');
        $listamovimentosatraso = $movimentopacController->RetornarAtraso($_GET['cod']);
        //   var_dump($listamovimentosatraso);

        if ($user->getStatus() == 1) {

            if ($listamovimentosatraso != null) {
                foreach ($listamovimentosatraso as $user4) {
                    if ($anoatual == $user4->getAno()) {
                        $diferenca = $mesatual - $user4->getMes();
                        if ($diferenca < 0) {
                            ?>
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-success alert-dismissible fade show" role="alert">
                                    <h3>Paciente com suas contas em dia. Apto para Consulta</h3>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <?php
                            if ($user->getStatus() == 2) {
                                ?>
                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                    <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                    <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                </form>
                                <?php
                            } else if ($user->getStatus() == 3) {
                                ?>
                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                    <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                    <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                </form>
                                <?php
                            }
                            ?>
                            <?php
                        }
                        if ($diferenca == 0) {
                            ?>
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-success alert-dismissible fade show" role="alert">
                                    <h3>Paciente com suas contas em dia. Apto para Consulta</h3>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <?php
                            if ($user->getStatus() == 2) {
                                ?>
                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                    <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                    <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                </form>
                                <?php
                            } else if ($user->getStatus() == 3) {
                                ?>
                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                    <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                    <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                </form>
                                <?php
                            }
                            ?>
                            <?php
                        }
                        if ($diferenca == 1) {
                            $diferencadia = $diaatual - $user4->getDia();
                            if ($diferencadia >= 0) {
                                $diferencadia = $diferencadia * (-1);
                                ?> 
                                <div class="col-md-12 mb-12" >
                                    <div style="" class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <div class="row">
                                            <div class="col-md-6 mb-6" >
                                                <h3>Primeiro Mês  de Inadimplência</h3>
                                            </div>
                                            <div class="col-md-6 mb-6" >
                                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                    <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                    <input  type="submit" value="Inabilitar Paciente" class="btn btn-outline-warning btn-lg" name="btnTrocaStatus" />
                                                </form>
                                            </div>
                                        </div>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <?php
                            } else {
                                $diferencadia = $diferencadia * (-1);
                                ?> 
                                <div class="col-md-12 mb-12" >
                                    <div style="" class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <h3>Faltam <?= $diferencadia ?> para o Primeiro Mês  de Inadimplência</h3>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <?php
                            }
                        } else if ($diferenca == 2) {
                            ?> 
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <div class="row">
                                        <div class="col-md-6 mb-6" >
                                            <h3>Segundo Mês  de Inadimplência</h3>
                                        </div>
                                        <div class="col-md-6 mb-6" >
                                            <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                <input  type="submit" value="Inabilitar Paciente" class="btn btn-outline-warning btn-lg" name="btnTrocaStatus" />
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <?php
                        } else if ($diferenca == 3) {
                            ?> 
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div class="row">
                                        <div class="col-md-6 mb-6" >
                                            <h3>Terceiro Mês  de Inadimplência</h3>
                                        </div>
                                        <div class="col-md-6 mb-6" >
                                            <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                <input  type="submit" value="Fechar Contrato" class="btn btn-outline-danger btn-lg" name="btnFecharContrato" />
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                </div>
                            </div>
                            <?php
                        } else if ($diferenca > 3) {
                            ?> 
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div class="row">
                                        <div class="col-md-6 mb-6" >
                                            <h3>Contrato deve ser fechado imediatamente</h3>
                                        </div>
                                        <div class="col-md-6 mb-6" >
                                            <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                <input  type="submit" value="Fechar Contrato" class="btn btn-outline-danger btn-lg" name="btnFecharContrato" />
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                </div>
                            </div>
                            <?php
                        }
                    } else if ($anoatual > $user4->getAno()) {
                        //  echo "ano atual maior que o ano Parcela";
                        echo "</br>";
                        $mesatual = $mesatual + 12;
                        $diferenca = $mesatual - $user4->getMes();
                        if ($diferenca == 0) {
                            ?>
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-success alert-dismissible fade show" role="alert">
                                    <h3>Paciente com suas contas em dia. Apto para Consulta</h3>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <?php
                                    if ($user->getStatus() == 2) {
                                        ?>
                                        <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                            <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                            <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                        </form>
                                        <?php
                                    } else if ($user->getStatus() == 3) {
                                        ?>
                                        <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                            <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                            <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                        </form>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        if ($diferenca == 1) {
                            $diferencadia = $diaatual - $user4->getDia();
                            if ($diferencadia >= 0) {
                                $diferencadia = $diferencadia * (-1);
                                ?> 
                                <div class="col-md-12 mb-12" >
                                    <div style="" class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <div class="row">
                                            <div class="col-md-6 mb-6" >
                                                <h3>Primeiro Mês  de Inadimplência</h3>
                                            </div>
                                            <div class="col-md-6 mb-6" >
                                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                    <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                    <input  type="submit" value="Inabilitar Paciente" class="btn btn-outline-warning btn-lg" name="btnTrocaStatus" />
                                                </form>
                                            </div>
                                        </div>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <?php
                            } else {
                                $diferencadia = $diferencadia * (-1);
                                ?> 
                                <div class="col-md-12 mb-12" >
                                    <div style="" class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <h3>Faltam <?= $diferencadia ?> para o Primeiro Mês  de Inadimplência</h3>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <?php
                            }
                        } else if ($diferenca == 2) {
                            ?> 
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <div class="row">
                                        <div class="col-md-6 mb-6" >
                                            <h3>Segundo Mês  de Inadimplência</h3>
                                        </div>
                                        <div class="col-md-6 mb-6" >
                                            <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                <input  type="submit" value="Inabilitar Paciente" class="btn btn-outline-warning btn-lg" name="btnTrocaStatus" />
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <?php
                        } else if ($diferenca == 3) {
                            ?> 
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div class="row">
                                        <div class="col-md-6 mb-6" >
                                            <h3>Terceiro Mês  de Inadimplência</h3>
                                        </div>
                                        <div class="col-md-6 mb-6" >
                                            <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                <input  type="submit" value="Fechar Contrato" class="btn btn-outline-danger btn-lg" name="btnFecharContrato" />
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                </div>
                            </div>
                            <?php
                        } else if ($diferenca > 3) {
                            ?> 
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div class="row">
                                        <div class="col-md-6 mb-6" >
                                            <h3>Contrato deve ser fechado imediatamente</h3>
                                        </div>
                                        <div class="col-md-6 mb-6" >
                                            <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                <input  type="submit" value="Fechar Contrato" class="btn btn-outline-danger btn-lg" name="btnFecharContrato" />
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                </div>
                            </div>
                            <?php
                        }
                    } else if ($anoatual < $user4->getAno()) {
                        ?>
                        <div class="col-md-12 mb-12" >
                            <div style="" class="alert alert-success alert-dismissible fade show" role="alert">
                                <h3>Paciente com suas contas em dia. Apto para Consulta </h3>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?php
                                if ($user->getStatus() == 2) {
                                    ?>
                                    <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                        <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                        <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                    </form>
                                    <?php
                                } else if ($user->getStatus() == 3) {
                                    ?>
                                    <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                        <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                        <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                    </form>
                                    <?php
                                }
                                ?>
                            </div>

                        </div>
                        <?php
                        // echo "ano atual menor que o ano Parcela";
                    }
                }
            }
        } else if ($user->getStatus() == 2) {

            if ($listamovimentosatraso != null) {
                foreach ($listamovimentosatraso as $user4) {

                    if ($anoatual == $user4->getAno()) {

                        $diferenca = $mesatual - $user4->getMes();
                        if ($diferenca < 0) {
                            ?>
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-success alert-dismissible fade show" role="alert">
                                    <h3>Paciente com suas contas em dia. Apto para Consulta</h3>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <?php
                            if ($user->getStatus() == 2) {
                                ?>
                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                    <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                    <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                </form>
                                <?php
                            } else if ($user->getStatus() == 3) {
                                ?>
                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                    <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                    <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                </form>
                                <?php
                            }
                            ?>
                            <?php
                        }
                        if ($diferenca == 0) {
                            ?>
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-success alert-dismissible fade show" role="alert">
                                    <h3>Paciente com suas contas em dia. Apto para Consulta</h3>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <?php
                            if ($user->getStatus() == 2) {
                                ?>
                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                    <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                    <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                </form>
                                <?php
                            } else if ($user->getStatus() == 3) {
                                ?>
                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                    <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                    <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                </form>
                                <?php
                            }
                            ?>
                            <?php
                        }
                        if ($diferenca == 1) {
                            $diferencadia = $diaatual - $user4->getDia();
                            if ($diferencadia >= 0) {
                                $diferencadia = $diferencadia * (-1);
                                ?> 
                                <div class="col-md-12 mb-12" >
                                    <div style="" class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <div class="row">
                                            <div class="col-md-6 mb-6" >
                                                <h3>Primeiro Mês  de Inadimplência</h3>
                                            </div>
                                            <div class="col-md-6 mb-6" >
                                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                    <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                    <input  type="submit" value="Inabilitar Paciente" class="btn btn-outline-warning btn-lg" name="btnTrocaStatus" />
                                                </form>
                                            </div>
                                        </div>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <?php
                            } else {
                                $diferencadia = $diferencadia * (-1);
                                ?> 
                                <div class="col-md-12 mb-12" >
                                    <div style="" class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <h3>Faltam <?= $diferencadia ?> para o Primeiro Mês  de Inadimplência</h3>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <?php
                            }
                        } else if ($diferenca == 2) {
                            ?> 
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <div class="row">
                                        <div class="col-md-6 mb-6" >
                                            <h3>Segundo Mês  de Inadimplência</h3>
                                        </div>
                                        <div class="col-md-6 mb-6" >
                                            <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                <input  type="submit" value="Inabilitar Paciente" class="btn btn-outline-warning btn-lg" name="btnTrocaStatus" />
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <?php
                        } else if ($diferenca == 3) {
                            ?> 
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div class="row">
                                        <div class="col-md-6 mb-6" >
                                            <h3>Terceiro Mês  de Inadimplência</h3>
                                        </div>
                                        <div class="col-md-6 mb-6" >
                                            <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                <input  type="submit" value="Fechar Contrato" class="btn btn-outline-danger btn-lg" name="btnFecharContrato" />
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                </div>
                            </div>
                            <?php
                        } else if ($diferenca > 3) {
                            ?> 
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div class="row">
                                        <div class="col-md-6 mb-6" >
                                            <h3>Contrato deve ser fechado imediatamente</h3>
                                        </div>
                                        <div class="col-md-6 mb-6" >
                                            <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                <input  type="submit" value="Fechar Contrato" class="btn btn-outline-danger btn-lg" name="btnFecharContrato" />
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                </div>
                            </div>
                            <?php
                        }
                    } else if ($anoatual > $user4->getAno()) {
                        //  echo "ano atual maior que o ano Parcela";
                        echo "</br>";
                        $mesatual = $mesatual + 12;
                        $diferenca = $mesatual - $user4->getMes();
                        if ($diferenca == 0) {
                            ?>
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-success alert-dismissible fade show" role="alert">
                                    <h3>Paciente com suas contas em dia. Apto para Consulta</h3>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <?php
                                    if ($user->getStatus() == 2) {
                                        ?>
                                        <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                            <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                            <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                        </form>
                                        <?php
                                    } else if ($user->getStatus() == 3) {
                                        ?>
                                        <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                            <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                            <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                        </form>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        if ($diferenca == 1) {
                            $diferencadia = $diaatual - $user4->getDia();
                            if ($diferencadia >= 0) {
                                $diferencadia = $diferencadia * (-1);
                                ?> 
                                <div class="col-md-12 mb-12" >
                                    <div style="" class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <div class="row">
                                            <div class="col-md-6 mb-6" >
                                                <h3>Primeiro Mês  de Inadimplência</h3>
                                            </div>
                                            <div class="col-md-6 mb-6"  >
                                                <p style="margin:5px; font-size: 16pt;">Verifique pagamento!</p>
                                            </div>
                                        </div>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <?php
                            } else {
                                $diferencadia = $diferencadia * (-1);
                                ?> 
                                <div class="col-md-12 mb-12" >
                                    <div style="" class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <h3>Faltam <?= $diferencadia ?> para o Primeiro Mês  de Inadimplência</h3>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <?php
                            }
                        } else if ($diferenca == 2) {
                            ?> 
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <div class="row">
                                        <div class="col-md-6 mb-6" >
                                            <h3>Segundo Mês  de Inadimplência</h3>
                                        </div>
                                        <div class="col-md-6 mb-6" >
                                            <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                <input  type="submit" value="Inabilitar Paciente" class="btn btn-outline-warning btn-lg" name="btnTrocaStatus" />
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <?php
                        } else if ($diferenca == 3) {
                            ?> 
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div class="row">
                                        <div class="col-md-6 mb-6" >
                                            <h3>Terceiro Mês  de Inadimplência</h3>
                                        </div>
                                        <div class="col-md-6 mb-6" >
                                            <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                <input  type="submit" value="Fechar Contrato" class="btn btn-outline-danger btn-lg" name="btnFecharContrato" />
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                </div>
                            </div>
                            <?php
                        } else if ($diferenca > 3) {
                            ?> 
                            <div class="col-md-12 mb-12" >
                                <div style="" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div class="row">
                                        <div class="col-md-6 mb-6" >
                                            <h3>Contrato deve ser fechado imediatamente</h3>
                                        </div>
                                        <div class="col-md-6 mb-6" >
                                            <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                <input  type="hidden" value="<?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                                <input  type="submit" value="Fechar Contrato" class="btn btn-outline-danger btn-lg" name="btnFecharContrato" />
                                            </form>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                </div>
                            </div>
                            <?php
                        }
                    } else if ($anoatual < $user4->getAno()) {
                        ?>
                        <div class="col-md-12 mb-12" >
                            <div style="" class="alert alert-success alert-dismissible fade show" role="alert">
                                <h3>Paciente com suas contas em dia. Apto para Consulta </h3>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?php
                                if ($user->getStatus() == 2) {
                                    ?>
                                    <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                        <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                        <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                    </form>
                                    <?php
                                } else if ($user->getStatus() == 3) {
                                    ?>
                                    <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                        <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                        <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                    </form>
                                    <?php
                                }
                                ?>
                            </div>

                        </div>
                        <?php
                        // echo "ano atual menor que o ano Parcela";
                    }
                }
            }
        } else if ($user->getStatus() == 3) {
            
        }
        //  var_dump($listamovimentosPac);
        ?>
        <div class="row">
            <div class="col-8 col-md-8" style="text-align: right;">
                <a target="_blank" href="Impressoes/Imprimir.php?pagina=3&cod=<?= $_GET['cod']; ?>" style="" class="btn btn-outline-info badge-pill" >Imprimir</a>
                <a style="" class="btn btn-outline-warning badge-pill" data-toggle="modal" data-target="#exampleModal2">Editar</a>
                <a class="btn btn-outline-dark badge-pill" data-toggle="modal" data-target="#exampleModal1">Anamnense</a>
                    
            </div>
            <div class="col-4 col-md-4" style="text-align: left;">
                <form name="form_cadastrarmovimento" method="post" action="" style="">
                    <input  type="submit" value="Lista de Espera" class="btn btn-outline-danger badge-pill" name="btnCadastrar" />
                </form>
            </div>
        </div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php if (!isset($_GET['consultas']) && !isset($_GET['outros'])) { ?> active <?php } ?>" href="painel.php?pagina=visualizar&cod=<?= $_GET['cod']; ?>">Dados Cadastrais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (isset($_GET['consultas'])) { ?> active <?php } ?>" href="painel.php?pagina=visualizar&cod=<?= $_GET['cod']; ?>&consultas">Consultas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if (isset($_GET['outros'])) { ?> active <?php } ?>" href="painel.php?pagina=visualizar&cod=<?= $_GET['cod']; ?>&outros">Contrato</a>
            </li>
        </ul>﻿
        ﻿<?php
        echo $resultado;
        ?>
        <?php
        if (!isset($_GET['consultas']) && !isset($_GET['outros'])) {
            ?>
            <div class="col-12 col-md-12">
                <h3>Dados Cadastrais</h3>
                <div class="row">
                    <div class="col-12 col-md-6" style="margin-bottom: 10px;">
                        <div class="card">
                            <div class="card-body">
                                <small style="color:green;">Nome:</small>
                                <?= $user->getNome(); ?>.
                            </div>
                        </div> 
                    </div>
                    <div class="col-12 col-md-6" style="margin-bottom: 10px;" >
                        <div class="card">
                            <div class="card-body">
                                <small style="color:green;">Data de Nascimento:</small>
                                <?= $user->getNascimento(); ?>.
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6" style="margin-bottom: 10px;">
                        <div class="card">
                            <div class="card-body">
                                <small style="color:green;">RG:</small>
                                <?= $user->getRg(); ?>.
                            </div>
                        </div> 
                    </div>

                    <div class="col-12 col-md-6" style="margin-bottom: 10px;">
                        <div class="card">
                            <div class="card-body">
                                <small style="color:green;">CPF:</small>
                                <?= $user->getCpf(); ?>.
                            </div>
                        </div> 
                    </div>

                    <div class="col-12 col-md-6" style="margin-bottom: 10px;">
                        <div class="card">

                            <div class="card-body">
                                <small style="color:green;">Rua/Bairro:</small>
                                </br>
                                <?= $user->getEndereco(); ?>.
                                </br>
                                <?= $user->getNumero(); ?>.
                                </br>
                                <?= $user->getComplemento(); ?>. </div>

                        </div> 
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <small style="color:green;">Celular/Residencial:</small>
                                </br>
                                <?= $user->getCelular(); ?>.
                                </br>
                                <?= $user->getResidencial(); ?>.
                                </br>
                                </br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <b>Data de Cadastro: </b>
                        <small><?= $user->getData(); ?> </small>
                      
                    </div>
                </div> 
            </div>

            <?php
        }

        if (isset($_GET['consultas'])) {
            ?>
            <table class="table table-bordered">
                <tr>
                    <th style="text-align: center;">nº de consultas Mês: <?php echo mostraMes($mes_hoje); ?></th>
                    <?php
                    $listaOrcamentosMes = [];
                    $listaOrcamentosMes = $orcamentoController->RetornarOrcamentosConsulta(1, $_GET['cod'], $mes_hoje, $ano_hoje);
                    $cont = 0;
                    $ultpagamento = "";
                    $dataatraso = "";
                    if ($listaOrcamentosMes != null) {
                        foreach ($listaOrcamentosMes as $contadordeorcamento) {
                            $cont++;
                        }
                    }
                    ?>
                    <td style="text-align: center;"><?= $cont; ?></td>
                    <td colspan="2">
                        <?php
                        $listamovimentosPac = $movimentopacController->RetornarPac($_GET['cod'], 2);
                        //  var_dump($listamovimentosPac);

                        if ($listamovimentosPac != null) {
                            if ($cont < 4) {
                                ?>
                                <form method="post" name="frmCadastro" id="frmCadastro" novalidate enctype="multipart/form-data">
                                    <input type="hidden" name="txtCodPaciente" id="txtCodPaciente" value="<?= $_GET['cod']; ?>" >
                                    <input type="submit" class="btn btn-outline-primary badge-pill" style="width: 100%;" name="btnCadastrarOrca" id="btnCadastrarOrca" value="Nova Consulta">                                                        </form>
                                </form>
                                <?php
                            } else {
                                ?>
                                <div class='alert alert-warning'>nº máximo de consultas atingindo!</div>

                                <?php
                            }
                        } else {
                            ?>

                            <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center;"  >
				 <input  type="hidden" value=" <?= $_GET['cod']; ?>" id="txtCod" name="txtCod" />
                                <input  type="submit" value="Gerar Vínculo" class="btn btn-outline-success badge-pill" style="width: 100%;" name="bntGerarBoletos" />
                            </form>                
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Funcionário</th>
                    <th>#</th>
                </tr>
                <?php
                $textoStatus ="";
                $contOrc = 0;
                if ($listaOrcamentosMes != null) {
                    foreach ($listaOrcamentosMes as $user4) {
                        $contOrc++;
                        if ($user4->getStatus() == 1) {
                            $textoStatus = "Aberto";
                        } else if ($user4->getStatus() == 2) {
                            $textoStatus = "Finalizado";
                        }
                        ?>
                        <tr>
                            <td><?= $textoStatus; ?></td>
                            <td><?= $user4->getDia(); ?>/<?= $user4->getMes(); ?>/<?= $user4->getAno(); ?></td>
                            <td><?= $usuarioController->RetornarNome($user4->getFunc()); ?></td>
                            <td>
                                            <a href="?pagina=consulta&cod=<?= $user4->getCod(); ?>" style="margin:5px;" class="btn btn-outline-info badge-pill" >Ver [+]</a>
                           
                                <a target="_blank" href="Impressoes/Imprimir.php?pagina=5&cod=<?= $user4->getCod(); ?>" style="margin:5px;" class="btn btn-outline-info badge-pill" >Imprimir</a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>

            </table>
            <?php
        }

        if (isset($_GET['outros'])) {

            $listamovimentosPac = $movimentopacController->RetornarPac($_GET['cod'], 2);
            //  var_dump($listamovimentosPac);

            if ($listamovimentosPac != null) {
                ?>
                <h3>Parcelas a pagar</h3>
                <hr>
                <table class="table table-bordered table-striped"> 

                    <tr>
                        <th>
                            Descrição  
                        </th>
                        <th>
                            Valor  
                        </th>
                        <th>
                            Data Vencimento  
                        </th>
                        <th>
                            #   
                        </th>
                    </tr>
                    <?php
                    foreach ($listamovimentosPac as $user4) {
                        ?>
                        <tr>
                            <td>
                                <?= $user4->getDescricao(); ?>  
                            </td>
                            <td>
                                R$ <?= $total = number_format($user4->getTotal(), 2, ",", "."); ?> 
                            </td>
                            <td>
                                <?= $user4->getDia(); ?>/<?= $user4->getMes(); ?>/<?= $user4->getAno(); ?> 
                            </td>
                            <td>
                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:left; margin-left: 5px;">
                                    <input  type="hidden" value="<?= $user4->getCod(); ?>" id="txtCod" name="txtCod" />
                                    <input  type="submit" value="Pagar" class="btn btn-outline-success btn-lg" name="btnPagarParcela" />
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            } else {
                ?>
                <div class="card mb-4 box-shadow">
                    <div class="card-header" style="background-color: navy;">
                        <h4 class="my-0 font-weight-normal" style="color:#fff;">Contrato</h4>
                    </div>
                    <div class="card-body">   
                        <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center;"  >
			    <div class='row'>

				<div class="col-md-4 mb-4">
            
				<select style='margin-left:50px; text-align:center; height:70px; border:none; font-size: 12pt; width: 100%; background-color:#fff;' name='txtDiaAtual' id='txtDiaAtual' onchange='PesquisarPagamentos(23, this.value, parampagmes.value, parampagano.value, paramtipopag.value)'  class='form-control'>
								<?php	for ($i = 1; $i <= 31; $i++) {
									echo "
										<option style='text-align:center;' value='$i'"; if($i==$dia_hoje){ echo "selected='selected'";} echo">Dia $i</option>
										 ";
								}
								?>
				</select>

				</div>


				<div class="col-md-4 mb-4">
            
				<select style='margin-left:50px; text-align:center; height:70px; border:none; font-size: 12pt; width: 100%; background-color:#fff;' name='txtMesAtual' id='txtMesAtual' onchange='PesquisarPagamentos(23, this.value, parampagmes.value, parampagano.value, paramtipopag.value)'  class='form-control'>
								<?php	for ($i = 1; $i <= 31; $i++) {
									echo "
										<option style='text-align:center;' value='$i'"; if($i==$mes_hoje){ echo "selected='selected'";} echo">Mes $i</option>
										 ";
								}
								?>
				</select>

				</div>


				<div class="col-md-4 mb-4">
            
				<select style='margin-left:50px; text-align:center; height:70px; border:none; font-size: 12pt; width: 100%; background-color:#fff;' name='txtAnoAtual' id='txtAnoAtual' onchange='PesquisarPagamentos(23, this.value, parampagmes.value, parampagano.value, paramtipopag.value)'  class='form-control'>
								<?php	for ($i = 2018; $i <= 2030; $i++) {
									echo "
										<option style='text-align:center;' value='$i'"; if($i==$ano_hoje){ echo "selected='selected'";} echo">Ano $i</option>
										 ";
								}
								?>
				</select>

				</div>
			    </div>	
                            <input  type="hidden" value=" <?= $_GET['cod'] ?>" id="txtCod" name="txtCod" />
                            <input  type="submit" value="Gerar Vínculo" class="btn btn-outline-success btn-lg" style="width: 100%;" name="bntGerarBoletos" />
                        </form>                
                    </div>
                </div>
                <?php
            }

            $listamovimentosPac = $movimentopacController->RetornarPac($_GET['cod'], 1);
            //  var_dump($listamovimentosPac);

            if ($listamovimentosPac != null) {
                ?>
                <h1>Parcelas Pagas</h1>         
                <table class="table table-bordered table-striped"> 
                    <tr>
                        <th>
                            Descrição  
                        </th>
                        <th>
                            Valor  
                        </th>
                        <th>
                            Data Vencimento  
                        </th>
                    </tr>
                    <?php
                    foreach ($listamovimentosPac as $user4) {
                        ?>
                        <tr>
                            <td>
                                <?= $user4->getDescricao(); ?>  
                            </td>
                            <td>
                                R$ <?= $total = number_format($user4->getTotal(), 2, ",", "."); ?> 
                            </td>
                            <td>
                                <?= $user4->getDia(); ?>/<?= $user4->getMes(); ?>/<?= $user4->getAno(); ?> 
                            </td>

                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            }
        }
    }
}
$VerdadeiroOuFalso = 0;
$termo = "";
$cod_usu2 = $user->getId();
$tipo = 1;
$listaAnamnesesBusca = $anamneseController->RetornarAnamnese($termo, $cod_usu2, $tipo);
//var_dump($listaAnamnesesBusca);
if ($listaAnamnesesBusca != null) {
    foreach ($listaAnamnesesBusca as $user2) {
        $cod_usu2 = $user2->getCod_usu();
        $dentista_antes = $user2->getDentista_antes();
        $reacao_anestesia = $user2->getReacao_anestesia();
        $como = $user2->getComo();
        $alergia_medicamento = $user2->getAlergia_medicamento();
        $qual = $user2->getQual();
        $outras_alergias = $user2->getOutras_alergia();
        $doencas = $user2->getDoencas();
        $doenca_familia = $user2->getDoenca_familia();
        $medicamento = $user2->getMedicamento();
        $data2 = $user2->getData();
        $VerdadeiroOuFalso = 1;
    }
}
?>
<style>
    #eusouomestre:hover{
        color:#fff;
    }
</style>
<!-- Modal ANANMENSE -->
<div class="modal fade bd-example-modal-lg" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Anmenese</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="row">   
                        <div class="col-md-12 order-md-1">
                            <?php
                            if ($VerdadeiroOuFalso == 0) {
                                ?>
                                <form method="post" name="frmCadastro" id="frmCadastro" novalidate enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="txtDentista1">Já foi ao dentista antes?</label>
                                            <select class="custom-select d-block w-100" id="txtDentista1" name="txtDentista1" required="">
                                                <option value="1">Sim</option>
                                                <option value="0">Não</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="txtReacao">Já teve alguma reação à anestesia?</label>
                                            <select class="custom-select d-block w-100" id="txtReacao" name="txtReacao" required="">
                                                <option value="1" >Sim</option>
                                                <option value="0" >Não</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="txtComo">Se sim, como reage a anestesia?</label>
                                            <input type="text" class="form-control" id="txtComo" name="txtComo" placeholder="" value="<?= $responsavel; ?>" required="">
                                            <div class="invalid-feedback">
                                                Responsável requerido.
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="txtAlergiaMedicamento">Tem alergia a algum medicamento?</label>
                                            <select class="custom-select d-block w-100" id="txtAlergiaMedicamento" name="txtAlergiaMedicamento" required="">
                                                <option value="1" >Sim</option>
                                                <option value="0" >Não</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="txtQual">Se sim, qual?</label>
                                            <input type="text" class="form-control" id="txtQual" name="txtQual" placeholder="" value="<?= $responsavel; ?>" required="">
                                            <div class="invalid-feedback">
                                                Responsável requerido.
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="txtOutrasAlergias">Outras alergias?</label>
                                            <input type="text" class="form-control" id="txtOutrasAlergias" name="txtOutrasAlergias" placeholder="" value="<?= $responsavel; ?>" required="">
                                            <div class="invalid-feedback">
                                                Responsável requerido.
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="txtDoencas">Tem ou teve alguma dessas doenças?</label>
                                            <div class="form-check">
                                                <div class="row" style="margin:10px;">
                                                    <div style="width: 30%;">
                                                        <input type="checkbox" class="form-check-input" id="Diabets" name="Diabets" value="on">
                                                        <label class="form-check-label" for="Diabets">Diabets</label>
                                                    </div>
                                                    <div style="width: 30%;">
                                                        <input type="checkbox" class="form-check-input" id="Hipertensao" name="Hipertensao">
                                                        <label class="form-check-label" for="Hipertensao">Hipertensão</label>
                                                    </div>
                                                    <div style="width: 30%;">
                                                        <input type="checkbox" class="form-check-input" id="HIV" name="HIV" value="HIV">
                                                        <label class="form-check-label" for="HIV">HIV</label>
                                                    </div>
                                                    <div style="width: 30%;">
                                                        <input type="checkbox" class="form-check-input" id="Hepatite" name="Hepatite">
                                                        <label class="form-check-label" for="Hepatite">Hepatite</label>
                                                    </div>

                                                    <div style="width: 30%;">
                                                        <input type="checkbox" class="form-check-input" id="ProblemasRenais" name="ProblemasRenais">
                                                        <label class="form-check-label" for="ProblemasRenais">Problemas Renais</label>
                                                    </div>
                                                    <div style="width: 30%;">
                                                        <input type="checkbox" class="form-check-input" id="ProblemasPulmonares" name="ProblemasPulmonares">
                                                        <label class="form-check-label" for="ProblemasPulmonares">Problemas Pulmonares</label>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="txtOutradoenca">Alguma outra Doença?</label>
                                            <input type="text" class="form-control" id="txtOutradoenca" name="txtOutradoenca" placeholder="" value="<?= $responsavel; ?>" required="">
                                            <div class="invalid-feedback">
                                                Responsável requerido.
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="txtDoencasfamilias">Tem na família algum tipo de doença?</label>
                                            <input type="text" class="form-control" id="txtDoencasfamilias" name="txtDoencasfamilias" placeholder="" value="<?= $responsavel; ?>" required="">
                                            <div class="invalid-feedback">
                                                Responsável requerido.
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="txtMedicamento">Faz uso de algum medicamento?</label>
                                            <input type="text" class="form-control" id="txtMedicamento" name="txtMedicamento" placeholder="" value="<?= $responsavel; ?>" required="">
                                            <div class="invalid-feedback">
                                                Responsável requerido.
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" name="btnVoltar" id="btnSubmit1" value="Voltar" data-dismiss="modal"  class="btn btn-secondary"/>
                                        <input type="submit" name="btnCadastrarAnamnese" id="btnSubmit" value="Cadastrar"  class="btn btn-primary" />
                                        <input type="hidden"  id="txtCodUsu" name="txtCodUsu" value="<?= $user->getId(); ?>">

                                    </div>
                                </form>
                                <?php
                            } else {
                                ?>
                                <div class="col-12 col-md-12">
                                    <div class="row">
                                        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <small style="color:green;">Já foi ao dentista antes?</small>
                                                    <?= ($dentista_antes == "1" ? "Sim" : "Não") ?>        

                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <small style="color:green;">Já teve alguma reação à anestesia?</small>
                                                    <?= ($reacao_anestesia == "1" ? "Sim" : "Não") ?>        

                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <small style="color:green;">Como?</small>
                                                    <?= $como; ?>        

                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <small style="color:green;">Tem alergia a algum medicamento?</small>
                                                    <?= ($alergia_medicamento == "1" ? "Sim" : "Não") ?>        

                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <small style="color:green;">Se sim, qual?</small>
                                                    <?= $qual ?>        
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <small style="color:green;">Outras Alergias?</small>
                                                    <?= $outras_alergias; ?>        

                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <small style="color:green;">Tem ou teve alguma dessas doenças?</small>
                                                    <?= $doencas ?>        

                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <small style="color:green;">Tem na família algum tipo de doença?</small>
                                                    <?= $doenca_familia; ?>        

                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <small style="color:green;">Faz uso de algum medicamento?</small>
                                                    <?= $medicamento; ?>        

                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" name="btnVoltar" id="btnSubmit1" value="Voltar" data-dismiss="modal"  class="btn btn-secondary"/>

                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if ($listaPacientesBusca != null) {
    foreach ($listaPacientesBusca as $user) {
        $cod = $user->getId();
        $nome = $user->getNome();
        $nascimento = $user->getNascimento();
        $rg = $user->getRg();
        $cpf = $user->getCpf();
        $endereco = $user->getEndereco();
        $numero = $user->getNumero();
        $complemento = $user->getComplemento();
        $celular = $user->getCelular();
        $residencial = $user->getResidencial();
        $responsavel = $user->getResponsavel();
        $indicacao = $user->getIndicacao();
        $data = $user->getData();
        $status = $user->getStatus();
        $dr = $user->getDr();
    }
}
?>
<!-- Modal EDITAR -->
<div class="modal fade bd-example-modal-lg" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Editar Dados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="row">   
                        <div class="col-md-12 order-md-1">
                            <form method="post" name="frmCadastro" id="frmCadastro" novalidate enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="txtNome">Nome Completo:</label>
                                        <input type="text" class="form-control" id="txtNome" name="txtNome" placeholder="" value="<?= $nome; ?>" required="">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="txtNascimento">Data Nascimento:</label>
                                        <input type="text" class="form-control" id="txtNascimento" name="txtNascimento" placeholder="" value="<?= $nascimento; ?>" required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="txtRg">RG:</label>
                                        <input type="text" class="form-control" id="txtRg"  name="txtRg" placeholder="" value="<?= $rg; ?>" required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="txtCpf2">CPF:</label>
                                        <input type="text" class="form-control" id="txtCpf" name="txtCpf" placeholder="" value="<?= $cpf; ?>" required="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="txtRua">Rua:</label>
                                        <input type="text" class="form-control" id="txtRua" name="txtRua" placeholder="" value="<?= $endereco; ?>" required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="txtNumero">nº:</label>
                                        <input type="text" class="form-control" id="txtNumero"  name="txtNumero" placeholder="" value="<?= $numero; ?> " required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="txtComplemento">Complemento:</label>
                                        <input type="text" class="form-control" id="txtComplemento" name="txtComplemento" placeholder="" value="<?= $complemento; ?> " required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="txtCelular2">Celular:</label>
                                        <input type="text" class="form-control" id="txtCelular" name="txtCelular" placeholder="" value="<?= $celular; ?> " required="">
                                        <div class="invalid-feedback">
                                            Celular requerido.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="txtStatus">Status</label>
                                        <select class="custom-select d-block w-100" id="txtStatus" name="txtStatus" required="">
                                            <option value="1" <?= ($status == "1" ? "selected='selected'" : "") ?>>Apto</option>
                                            <option value="2" <?= ($status == "2" ? "selected='selected'" : "") ?>>Inapto</option>
                                            <option value="3" <?= ($status == "3" ? "selected='selected'" : "") ?>>Desvinculado</option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="mb-4">
                                <input type="submit" name="btnSubmitEd" id="btnSubmitEd" value="Editar"  class="btn btn-warning btn-lg btn-block" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>