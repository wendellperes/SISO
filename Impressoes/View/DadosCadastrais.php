
<?php
$erros = [];

require_once("../Model/Paciente.php");
require_once("../Controller/PacienteController.php");

require_once("../Model/Anamnese.php");
require_once("../Controller/AnamneseController.php");

$anamneseController = new AnamneseController();
$pacienteController = new PacienteController();

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
$resultado = "";
$listaPacientesBusca = [];

$id = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
$tipo = 1;
if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
    $termo = "";
    $status = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
    $tipo = 2;
    $listaPacientesBusca = $pacienteController->RetornarPacientes($termo, $tipo, $status);
//var_dump($listaPacientesBusca);
}

?>
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
        </table>
        <table class="table table-bordered"> 
            <tr>
                <td colspan="4" style="text-align: center;">
                    <h4 class="mb-3">Dados Cadastrais</h4>
                </td>
            </tr>
        </table>

        <table class="table table-bordered"> 
            <?php
            if ($listaPacientesBusca != null) {
                foreach ($listaPacientesBusca as $user) {
                    ?>
                    <tr>
                        <th style="text-align: right;">
                            Nome:
                        </th>
                        <td colspan="3">
                            <?= $user->getNome(); ?>
                        </td>                
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            RG:
                        </th>
                        <td>
                            <?= $user->getRg(); ?> 
                        </td>
                        <th style="text-align: right;">
                            CPF:
                        </th>
                        <td>
                            <?= $user->getCpf(); ?>
                        </td>
                    </tr>

                    <tr>
                        <th style="text-align: right;">
                            Endereço:
                        </th>
                        <td colspan="">
                            <b>Rua/Bairro:</b> <?= $user->getEndereco(); ?></br>  <b>nº:</b> <?= $user->getNumero(); ?></br>  <b>Complemento:</b> <?= $user->getComplemento(); ?>
                        </td> 
                        <th style="text-align: right;">
                            Celular:
                        </th>
                        <td colspan="3">
                            <?= $user->getCelular(); ?>
                        </td> 
                    </tr>
                    <?php
                    $datacadastro = $user->getData();
                }
            }
            ?>
        </table>
        <?php
        $VerdadeiroOuFalso = 0;
        $termo = "";
        $cod_usu2 = $_GET['cod'];
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
                ?>
                <table class="table table-bordered">

                    <tr>
                        <td colspan="4" style="text-align: center;">
                            <h4 class="mb-3">Anamense</h4>
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <tr>
                        <th style="text-align: right;">
                            Já foi ao dentista antes?
                        </th>
                        <td>
                            <?= ($dentista_antes == "1" ? "Sim" : "Não") ?>        
                        </td>
                        <th style="text-align: right;">
                            Já teve alguma reação à anestesia?
                        </th>
                        <td>
                            <?= ($reacao_anestesia == "1" ? "Sim" : "Não") ?>        
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            Como?
                            </h>
                        <td colspan="3">
                            <?= $como; ?>        
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            Tem alergia a algum medicamento?
                        </th>
                        <td>
                            <?= ($alergia_medicamento == "1" ? "Sim" : "Não") ?>        
                        </td>
                        <th style="text-align: right;">
                            Se sim, qual?
                        </th>
                        <td>
                            <?= $qual ?>        
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            Outras Alergias?
                        </th>
                        <td colspan="3">
                            <?= $outras_alergias; ?>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            Tem ou teve alguma dessas doenças?
                        </th>
                        <td colspan="3">
                            <?= $doencas ?>        
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align: right;">
                            Tem na família algum tipo de doença?
                        </th>
                        <td colspan="3">
                            <?= $doenca_familia; ?>
                        </td>
                    </tr>

                    <tr>
                        <th style="text-align: right;">
                            Faz uso de algum medicamento?
                        </th>
                        <td colspan="3">
                            <?= $medicamento; ?>   
                        </td>
                    </tr>
                </table>
                <?php
            }
        }
        ?>
      <table class="table table-bordered">
          <th style="text-align: right;">Data Cadastro:</th>
          <td  colspan="3">
              <?= $datacadastro; ?>
          </td>
      </table>
    </div>
</div>

