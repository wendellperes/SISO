<?php
$erros = [];

require_once("../Model/Paciente.php");
require_once("../Model/Anamnese.php");
require_once("../Model/Orcamento.php");
require_once("../Model/Procedimento.php");
require_once("../Model/Pagamento.php");
require_once("../Model/PagParPro.php");
require_once ("../Model/Listaespera.php");
require_once ("../Model/Dente.php");
require_once ("../Model/Servico.php");

require_once("../Controller/PacienteController.php");
require_once("../Controller/AnamneseController.php");
require_once("../Controller/OrcamentoController.php");
require_once("../Controller/ProcedimentoController.php");
require_once("../Controller/PagamentoController.php");
require_once("../Controller/PagParProController.php");
require_once("../Controller/ListaEsperaController.php");
require_once("../Controller/DenteController.php");
require_once("../Controller/ServicoController.php");


$pacienteController = new PacienteController();
$anamneseController = new AnamneseController();
$orcamentoController = new OrcamentoController();
$pagamentoController = new PagamentoController();
$pagparproController = new PagParProController();
$procedimentoController = new ProcedimentoController();
$denteController = new DenteController();
$servicoController = new ServicoController();
$listaesperaController = new ListaesperaController();

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
        $doencas = $doencas . "Problemas Pulmonares  - ";
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
if (filter_input(INPUT_POST, "btnCadastrarPagParPro", FILTER_SANITIZE_STRING)) {
    $descricao_parcela = (filter_input(INPUT_POST, "txtDescricao", FILTER_SANITIZE_STRING));
    $valor_parcela2 = (filter_input(INPUT_POST, "txtValor", FILTER_SANITIZE_STRING));

    $pontos = '.';
    $result = str_replace($pontos, "", $valor_parcela2);


    $valor_parcela2 = (float) $result;

    $valor_parcela2 = number_format($valor_parcela2, 2, '.', ',');



    $financeiro_pac = (filter_input(INPUT_POST, "txtFinanceiro", FILTER_SANITIZE_NUMBER_INT));
    $tipopag = filter_input(INPUT_POST, "txtTipoPag", FILTER_SANITIZE_STRING);
    $esp_pro = filter_input(INPUT_POST, "txtEspPro", FILTER_SANITIZE_NUMBER_INT);


    $data_movimento = date('d/m/Y');

    $t = explode("/", $data_movimento);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];

    $pagparpro = new PagParPro();
    $pagparpro->setDescricao($descricao_parcela);
    $pagparpro->setValor($valor_parcela2);
    $pagparpro->setFinanceiro_pac($financeiro_pac);
    $pagparpro->setTipopag($tipopag);

    $pagparpro->setDia($dia);
    $pagparpro->setMes($mes);
    $pagparpro->setAno($ano);
    $pagparpro->setEsp_pro($esp_pro);


    if ($pagparproController->Cadastrar($pagparpro)) {

        $status = 3;
        $resultado = $procedimentoController->AlterStatusTodos2($status, $esp_pro);

        $resultado = "<div class='alert alert-success' role='alert'><span>Pagamento Cadastrado com Sucesso</span> </div>";
    } else {
        $resultado = "<div class='alert alert-danger' role='alert'><span>Houve um erro ao cadastrar parcela</span> </div>";
    }
}

$id = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
$tipo = 1;
$listaOrcamentos = $orcamentoController->RetornarOrcamentos($tipo, $id);

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

    if ($orcamentoController->Cadastrar($orcamento)) {
        $resultado = " <div class='alert alert-success' role='alert'><span>Orçamento cadastrado com sucesso!</span> </div>";
        header("location: painel.php?pagina=orcamento");
    } else {
        $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um herro ao cadastrar novo Orçamento!</span> </div>";
    }
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
if ($listaPacientesBusca != null) {
    foreach ($listaPacientesBusca as $user) {
        ?>
        <div class="col-md-12 mb-3">
            <hr class="mb-4"> 
            <h3 class="mb-3">Dados Pessoais - Paciente

            </h3>
            <!-- Button trigger modal -->

            <?php
            echo $resultado;
            ?>
        </div>
        <div class="col-12 col-md-12">
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
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header" id="headingTwo1">
                    <h5 class="mb-0">
                        <button class="btn btn-outline-info" style="width: 100%" type="button" data-toggle="collapse" data-target="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
                            Endereço
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        </br>
                        <small style="color:green;">Rua/Bairro:</small>
                        </br>
                        <?= $user->getEndereco(); ?>.
                        </br>
                        <?= $user->getNumero(); ?>.
                        </br>
                        <?= $user->getComplemento(); ?>. </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-outline-dark" style="width: 100%" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Contato
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        </br>
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
        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body">
                                <small style="color:green;">Responsavel:</small>
                                <?= $user->getResponsavel(); ?>.
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body">
                                <small style="color:green;">Indicação:</small>
                                <?= $user->getIndicacao(); ?>.
                            </div>
                        </div>
                    </div> 
                </div>
            </div>

        </div>
        <small class = "d-block text-right mt-3" style="position: relative; right: 10px; font-size: 14pt;">
            <a target="_blank" href ="../Impressoes/VisualizarPacienteIMPRE.php?cod=<?= $id; ?>">Imprimir Dados</a>
        </small>
        <small class = "d-block text-right mt-3" style="position: relative; right: 10px; font-size: 14pt;">
            <a href = "painel.php?pagina=paciente&cod=<?= $user->getId(); ?>">Editar Dados</a>
        </small>
        <div class="col-12 col-md-12" style="margin: 10px;">
            <div class="row">
                <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal1">
                    Anamnense
                </button>
            </div>
        </div>
        <div class="col-12 col-md-12" style="margin: 10px;">
            <div class="row">
                <button type="button" class="btn btn-dark btn-lg btn-block" style="background-color: #6495ED; border-color: #fff;" data-toggle="modal" data-target="#exampleModal2">
                    Procedimentos/Orgaçamentos
                </button>
            </div>
        </div>
        <div class="col-12 col-md-12" style="margin: 10px;">
            <div class="row">
                <button type="button" class="btn btn-info btn-lg btn-block" data-toggle="modal" data-target="#exampleModal3">
                    Financeiro
                </button>
            </div>
        </div>

        <div class="col-12 col-md-12" style="margin: 10px;">
            <div class="row">

                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:left; width: 100%;">
                    <input  type="submit" value="Adicionar à Lista de Espera" class="btn btn-dark btn-lg btn-block" name="btnCadastrar" />
                </form>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <small style="color:blue;">Data de Cadastro: </small>
                    <small style="color:green;"><?= $user->getData(); ?> </small>
                    <small style="color:red;">--</small>

                </div>
            </div> 
        </div>

        <?php
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
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Anmenese</h5>
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
                                        <button type="button" class="btn btn-info">
                                            <a style="color:#fff;" target="_blank" href ="../Impressoes/VisualizarAnamnenseIMPRE.php?cod=<?= $id; ?>">Imprimir Dados</a>

                                        </button>
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
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Orçamentos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="jumbotron mt-3">

                        <h1 style="color:#blue;">Novo Orçamento</h1>
                        <p class="lead"></p>
                        <form method="post" name="frmCadastro" id="frmCadastro" novalidate enctype="multipart/form-data">
                            <button type="submit" class="btn btn-dark" name="btnCadastrarOrca" id="btnCadastrarOrca" value="Cadastrar"> Clique aqui</button>
                        </form>
                    </div> 
                </div>               
                <?php
                if ($listaOrcamentos != null) {
                    foreach ($listaOrcamentos as $user4) {
                        ?>
                        <div class="jumbotron mt-2">

                            <h1 style="color:#blue;">Orçamento: nº <?= $user4->getCod(); ?></h1>

                            <div class="row">
                                <a style=""  class="btn btn-outline-success btn-lg" href="?pagina=orcamento&cod=<?= $user4->getCod(); ?>" role="button">Ir para orçamento</a>
                                <?php if ($user4->getStatus() == 1) { ?>
                                    <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center;"  >
                                        <input  type="hidden" value=" <?= $user4->getCod(); ?>" id="txtCod" name="txtCod" />

                                        <input  type="submit" value="Cancelar" class="btn btn-outline-danger btn-lg" name="btnCancelarOr" />

                                    </form>
                                <?php } ?>

                                <button type="button" class="btn btn-info" style="margin-left:5px;">
                                    <a style="color:#fff;" target="_blank" href ="../Impressoes/OrcamentoIMPRE.php?cod=<?= $user4->getCod(); ?>">Imprimir Procedimentos</a>

                                </button>
                            </div>

                        </div>


                        <?php
                    }
                } else {
                    ?>

                    <div class="jumbotron mt-2">

                        <h1 style="color:#0062cc;">Sem orçamentos</h1>
                        <p class="lead">Não há orçamentos cadastrados, por favor, clique no botão acima para adicionar novo orçamento</p>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="jumbotron mt-3">

                        <h1 style="color:#blue;">Financeiro Paciente </h1>
                        <p class="lead"></p>
                    </div> 
                </div>               
                <?php
                if ($listaOrcamentos != null) {
                    foreach ($listaOrcamentos as $user4) {
                        $id2 = $user4->getCod();
                        ?>
                        <div class="jumbotron mt-2">
                            <h1 style="color:#blue;">Orçamento: nº <?= $user4->getCod(); ?></h1>
                            <div class="col-12 col-md-12" style="margin: 10px;">
                                <div class="row">
                                    <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModal1">
                                        <a style="color:#fff;" target="_blank" href ="../Impressoes/OrcamentoFINIMPRE.php?cod=<?= $id2; ?>">Imprimir Financeiro</a>


                                    </button>
                                </div>
                            </div>



                            <?php
                            $listaPagamentos = $pagamentoController->RetornarPagamentos($id2);

                            if ($listaPagamentos != null) {
                                foreach ($listaPagamentos as $user5) {
                                    ?>
                                    <div class="row">
                                        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h1 style="color:blue;">Pagamento: nº <?= $user5->getCod(); ?></h1>    
                                                    <?php
                                                    $cod_pac = $user5->getCod();
                                                    ?>
                                                </div>
                                            </div> 
                                        </div>
                                        <?php
                                        if ($user5->getTipo() != 3) {
                                            ?>
                                            <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <?php
                                                        $pontos = ',';
                                                        $valor_completo = $user5->getTotal();
                                                        $valor_parcela = $user5->getTotal();
                                                        $result = str_replace($pontos, "", $valor_completo);
                                                        $valor_completo = (float) $result;

                                                        $valor_completo = number_format($valor_completo, 2, ',', '.');
                                                        ?>
                                                        <p style="color:blue;">Valor: <?= $valor_completo; ?> </p>   

                                                    </div>
                                                </div> 
                                            </div>
                                            <?php
                                        } else {
                                            $valor_parcela = $user5->getTotal();
                                        }
                                        ?>
                                        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <p style="color:blue;">Descrição:  <?= $user5->getDescricao(); ?></p>    
                                                </div>
                                            </div> 
                                        </div>
                                        <?php
                                        if ($user5->getTipo() == 2) {
                                            ?>
                                            <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p style="color:blue;">Parcelas:  <?= $user5->getNumparcelas(); ?></p> 
                                                        <?PHP
                                                        $qtdparcela = $user5->getNumparcelas();
                                                        ?>
                                                    </div>
                                                </div> 
                                            </div>
                                            <?php
                                        } else {
                                            $qtdparcela = 1;
                                        }
                                        ?>
                                        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <?PHP
                                                    $pontos = ',';

                                                    $result = str_replace($pontos, "", $valor_parcela);
                                                    $valor_parcela = (float) $result;

                                                    $totaltotal = ($qtdparcela) * ($valor_parcela);
                                                    $totaltotal = number_format($totaltotal, 2, ',', '.');
                                                    ?>
                                                    <p style="color:blue;">Total: <?= $totaltotal; ?></p> 

                                                </div>
                                            </div> 
                                        </div>

                                        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                            <div class="card">
                                                <div class="card-body">

                                                    <?php
                                                    if ($user5->getTipo() == 1) {
                                                        ?>
                                                        <p style="color:blue;">Tipo: á Vista </p>    
                                                        <p style="color:green;">Em: <?= $user5->getTipopag(); ?> </p>    

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

                                                                <?php
                                                            }
                                                            ?>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <?php
                                                                    if ($qtdparcela != $contador2) {
                                                                        ?>
                                                                        <form method="post" name="frmCadastro" id="frmCadastro" novalidate enctype="multipart/form-data">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-3">
                                                                                    <p><h4 style="color: blue;">Pagamento da parcela</h4></p>
                                                                                    <p style="color: green;"><small> Descrição: </small>Pagamento da parcela número <?= $contador; ?>.</p>
                                                                                    <div class="invalid-feedback">
                                                                                        Responsável requerido.
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-3">
                                                                                        <input type="hidden"  id="txtFinanceiro" name="txtFinanceiro" value="<?= $cod_pac; ?>">
                                                                                        <input type="hidden"  id="txtEspPro" name="txtEspPro" value="0">

                                                                                        <input type="hidden"  id="txtDescricao" name="txtDescricao" value=Pagamento da parcela número <?= $contador; ?>.">
                                                                                               <div class="card">
                                                                                            <div class="card-body">
                                                                                                <div class="col-md-12 mb-3">
                                                                                                    <label for="txtTipoPag  ">Valor:</label>
                                                                                                    <input type="text" class="form-control"   id="txtValor" name="txtValor" value="<?= number_format($valor_parcela, 2, ',', '.'); ?>">


                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="card">
                                                                                            <div class="card-body">
                                                                                                <div class="col-md-12 mb-3">
                                                                                                    <label for="txtTipoPag  ">Pagamento em:</label>
                                                                                                    <select class="custom-select d-block w-100" id="txtTipoPag" name="txtTipoPag" required="">

                                                                                                        <option value="Dinheiro" >Dinheiro</option>
                                                                                                        <option value="Debito" >Débito</option>
                                                                                                        <option value="Credito" >Crédito</option>
                                                                                                        <option value="A promissoria">Promissoria</option>

                                                                                                    </select>

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <input type="submit" name="btnCadastrarPagParPro" id="btnSubmit" value="Pagar parcela número <?= $contador; ?>"  class="btn btn-dark btn-lg btn-block" />

                                                                                    </div>
                                                                                </div>


                                                                            </div>
                                                                        </form>
                                                                        <?php
                                                                    } else {
                                                                        echo "<p>Pagamento encerrado!</p>";
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            ?>

                                                            <p style="color:blue;">Tipo de Pagamento: Parcelado </p>    
                                                            <form method="post" name="frmCadastro" id="frmCadastro" novalidate enctype="multipart/form-data">
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-3">
                                                                        <p><h4 style="color: blue;">Pagamento da parcela</h4></p>
                                                                        <p style="color: green;"><small> Descrição: </small>Pagamento da parcela número 01.</p>

                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="col-md-12 mb-3">
                                                                                    <label for="txtTipoPag  ">Valor:</label>
                                                                                    <input type="text" class="form-control"   id="txtValor" name="txtValor" value="<?= number_format($valor_parcela, 2, ',', '.'); ?>">


                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="col-md-12 mb-3">
                                                                                    <label for="txtTipoPag  ">Pagamento em:</label>
                                                                                    <select class="custom-select d-block w-100" id="txtTipoPag" name="txtTipoPag" required="">

                                                                                        <option value="Dinheiro" >Dinheiro</option>
                                                                                        <option value="Debito" >Débito</option>
                                                                                        <option value="Credito" >Crédito</option>
                                                                                        <option value="A promissoria">Promissoria</option>

                                                                                    </select>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="hidden"  id="txtFinanceiro" name="txtFinanceiro" value="<?= $cod_pac; ?>">
                                                                    <input type="hidden"  id="txtEspPro" name="txtEspPro" value="0">
                                                                    <input type="hidden"  id="txtDescricao" name="txtDescricao" value="Pagamento da parcela número 1">

                                                                    <div class="col-sm-12">

                                                                        <input type="submit" name="btnCadastrarPagParPro" id="btnCadastrarPagParPro" value="Pagar parcela número 1"  class="btn btn-dark btn-lg btn-block" />

                                                                    </div>

                                                                </div>
                                                            </form>
                                                            <?php
                                                        }
                                                    } else if ($user5->getTipo() == 3) {
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
                                                            if ($user->getStatus() == 2) {
                                                                $listaPagParPro = $pagparproController->RetornarM($cod_pac);
                                                        
                                                                ?>
                                                                <div class="card">
                                                                    <div class="card-header" id="headingTwo3">
                                                                        <h5 class="mb-0">
                                                                            <button class="btn btn-outline-info" style="width: 100%" type="button" data-toggle="collapse" data-target="#collapseTwo3" aria-expanded="false" aria-controls="collapseTwo1">
                                                                                PAGAMENTO DE MANUTENÇÃO 
                                                                            </button>
                                                                        </h5>
                                                                    </div>
                                                                    <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                                        <div class="card-body">
                                                                            <form style="background-color: #000;" method="post" name="frmCadastro" id="frmCadastro" novalidate enctype="multipart/form-data">
                                                                                <input type="hidden"  id="txtFinanceiro" name="txtFinanceiro" value="<?= $cod_pac; ?>">
                                                                                <input type="hidden"  id="txtEspPro" name="txtEspPro" value="0">

                                                                                <div class="col-md-12 mb-3">
                                                                                    <label style="color:white;" for="txtDescricao">Descrição:</label>
                                                                                    <input type="text" class="form-control"  id="txtDescricao" name="txtDescricao" value="MANUTENÇAO DO MÊS: <?= $mes = date('m'); ?>">


                                                                                </div>
                                                                                <div class="col-md-12 mb-3">
                                                                                    <label style="color:white;"  for="txtValor">Valor:</label>
                                                                                    <input type="text" class="form-control"  id="txtValor" name="txtValor" value="">

                                                                                </div>
                                                                                <div class="col-md-12 mb-3">
                                                                                    <label style="color:white;" for="txtTipoPag">Pagamento em:</label>
                                                                                    <select class="custom-select d-block w-100" id="txtTipoPag" name="txtTipoPag" required="">

                                                                                        <option value="Dinheiro" >Dinheiro</option>
                                                                                        <option value="Debito" >Débito</option>
                                                                                        <option value="Credito" >Crédito</option>
                                                                                        <option value="A promissoria">Promissoria</option>

                                                                                    </select>

                                                                                </div>
                                                                                <input type="submit" name="btnCadastrarPagParPro" id="btnCadastrarPagParPro" value="Pagar"  class="btn btn-outline-success" style="width: 100%" />

                                                                            </form>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php
                                                            } else {
                                                                $listaPagParPro = $pagparproController->RetornarTodos($cod_pac);
                                                        
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
                                                                                    <?php
                                                                                    if ($user10->getStatus() != 3) {
                                                                                        ?>
                                                                                        <form method="post" name="frmCadastro" id="frmCadastro" novalidate enctype="multipart/form-data">
                                                                                            <input type="hidden"  id="txtFinanceiro" name="txtFinanceiro" value="<?= $cod_pac; ?>">
                                                                                            <input type="hidden"  id="txtEspPro" name="txtEspPro" value="<?= $cod_procedimento3; ?>">

                                                                                            <input type="hidden"  id="txtDescricao" name="txtDescricao" value="<?= $nome_s; ?>">
                                                                                            <input type="hidden"  id="txtValor" name="txtValor" value="<?= $valor; ?>">

                                                                                            <div class="col-md-12 mb-3">
                                                                                                <label for="txtTipoPag  ">Pagamento em:</label>
                                                                                                <select class="custom-select d-block w-100" id="txtTipoPag" name="txtTipoPag" required="">

                                                                                                    <option value="Dinheiro" >Dinheiro</option>
                                                                                                    <option value="Debito" >Débito</option>
                                                                                                    <option value="Credito" >Crédito</option>
                                                                                                    <option value="A promissoria">Promissoria</option>

                                                                                                </select>

                                                                                            </div>
                                                                                            <input type="submit" name="btnCadastrarPagParPro" id="btnCadastrarPagParPro" value="Pagar"  class="btn btn-outline-success" style="width: 100%" />

                                                                                        </form>

                                                                                        <?php
                                                                                    } else {
                                                                                        ?>
                                                                                        <p style="color:green; text-align: center; width: 100%;"> <img style="width: 24px;" src="../Interface/img/tick-inside-circle.png">Pago</p>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </th>
                                                                            </tr>

                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>

                                                            <?php
                                                        }
                                                        ?>
                                                        <div class="card">
                                                            <div class="card-header" id="headingTwo<?= $cod_pac;?>">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-outline-success" style="width: 100%" type="button" data-toggle="collapse" data-target="#collapseTwo<?= $cod_pac;?>" aria-expanded="false" aria-controls="collapseTwo1">
                                                                        PAGOS 
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="collapseTwo<?= $cod_pac;?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                                <div class="card-body">
                                                                    <?php
                                                                   // $listaPagParPro2 = $pagparproController->RetornarM($cod_pac);
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
                                                                                    <p style="color:green;">Valor:  <?= $user6->getValor(); ?></p>    
                                                                                    <p style="color:#007bff;">Data:  <?= $user6->getDia() . '/' . $user6->getMes() . '/' . $user6->getAno(); ?></p>    
                                                                                    <p style="color:#007bff;">Pagamento em:  <?= $user6->getTipopag(); ?></p>    

                                                                                </div>
                                                                            </div>

                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <p style="color:#blue;">Data:  <?= $user5->getDia() . '/' . $user5->getMes() . '/' . $user5->getAno(); ?> </p>    
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php
                    }
                }
                ?>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>
</div>