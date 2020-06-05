<?php
require_once("Model/Paciente.php");

require_once("Model/Listaespera.php");

require_once("Controller/PacienteController.php");

require_once("Controller/ListaesperaController.php");

$pacienteController = new PacienteController();

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

$listaPacientesBusca = [];

$cod = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);

$cod2 = filter_input(INPUT_GET, "codevento", FILTER_SANITIZE_NUMBER_INT);

if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
    $termo = "";
    $status = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
    $tipo = 2;
    $listaPacientesBusca = $pacienteController->RetornarPacientes($termo, $tipo, $status);
//var_dump($listaPacientesBusca);
}
//var_dump($listaPacientesBusca);


if ($listaPacientesBusca != null) {
    foreach ($listaPacientesBusca as $user) {

        $nome = $user->getNome();
        $cod = $user->getId();

        $endereco = $user->getEndereco();
        $numero = $user->getNumero();
        $complemento = $user->getComplemento();
        $celular = $user->getCelular();
        $residencial = $user->getResidencial();
        $responsavel = $user->getResponsavel();
    }
}

$resultado = '';

if (filter_input(INPUT_POST, "btnCadastrar", FILTER_SANITIZE_STRING)) {
    $cod_paciente = $cod;
    $data = date('d/m/Y h:i:s');

    $listaespera = new Listaespera();
    $listaespera->setCod_paciente($cod_paciente);
    $listaespera->setData($data);

 $cod2 = filter_input(INPUT_GET, "codevento", FILTER_SANITIZE_NUMBER_INT);

    if ($listaesperaController->Cadastrar($listaespera)) {
        $listaesperaController->DeletarEvento($cod2);
        header('Location: painel.php');
        } else {
        $resultado = "Houve um erro ao cadastrar";
    }
}

if (filter_input(INPUT_POST, "btnApagar", FILTER_SANITIZE_STRING)) {
    $codevento = $cod2;
    
    
    if ($listaesperaController->DeletarEvento($codevento)) {
        header('Location: painel.php');
        } else {
        $resultado = "Houve um erro ao cadastrar";
    }
}

echo
$resultado;
?>
<style>
    #eusouomestre:hover{
        color:#fff;
    }
</style>

<link href="../Interface/Bootstrap/responsividade.css" rel="stylesheet" type="text/css"/>

<div class="container">
    <div class="jumbotron mt-3">
        <h1 style="color:#blue;">Confirmar Evento - Sorrident</h1>
        <p class="lead">Confirme ou Cancele o evento</p>

        <form name="form_cadastrarmovimento" method="post" action="" style="text-align:left;"  >
            <input  type="hidden" value="<?= $cod; ?>" id="txtCodPaciente" name="txtCodPaciente" />
           
            
            <input  type="submit" value="Confirmar Presença" class="btn btn-outline-success btn-lg" name="btnCadastrar" />
            <input  type="submit" value="Cancelar" class="btn btn-outline-danger btn-lg" name="btnApagar" />
       
       </form>
    </div>
</div>


<div class="col-12 col-md-12">
    <div class="col-12 col-md-12">
        <div class="card">
            <div class="card-header" id="headingTwo1">
                <h5 class="mb-0">
                    <button class="btn btn-outline-primary" style="width: 100%" type="button" data-toggle="collapse" data-target="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
                        <?= $nome; ?>
                    </button>
                </h5>
            </div>
            <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="card-body">
                            <p style="color:blue; font-size: 16pt;"><small>Celular: <?= $celular; ?></small> </p>
                            <p style="color:green; font-size: 16pt;"><small>Residencial: <?= $residencial; ?></small> </p>

                        </div>

                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card-body">
                            <p style="color:blue; font-size: 16pt;"><small>Endereço: <?= $endereco; ?></small> </p>
                            <p style="color:green; font-size: 16pt;"><small>Número: <?= $numero; ?></small> </p>
                            <p style="color:red; font-size: 16pt;"><small>Complemento: <?= $complemento; ?></small> </p>

                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card-body">
                            <p style="color:blue; font-size: 16pt;"><small>Responsável: <?= $responsavel; ?></small> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>	 
    </div>
</div>
<!-- Modal -->
