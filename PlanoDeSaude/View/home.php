<script>
    jQuery(function ($) {
           $("#txtCpf").mask("999.999.999-99",{placeholder:""});
        });
    $(document).ready(function () {
        $('#txtnome').mask('nome');
        $("#txtCpf").mask("999.999-9 A",{placeholder:""});
    })
    
</script>
<?php
date_default_timezone_set('America/Manaus');

require_once("../Model/Paciente.php");
require_once("../Controller/PacienteController.php");
require_once("../Model/Orcamento.php");
require_once("../Controller/OrcamentoController.php");
require_once("../Model/Pagamento.php");
require_once("../Model/AtivoPassivo.php");
require_once("../Controller/PagamentoController.php");
require_once("../Controller/MovimentoPacController.php");
require_once("../Controller/ListaesperaController.php");
require_once("../Model/Listaespera.php");

require_once("../Util/functions.php");

$pacienteController = new PacienteController();
$orcamentoController = new OrcamentoController();
$pagamentoController = new PagamentoController();
$movimentopacController = new MovimentoPacController();
$listaesperaController = new ListaesperaController();

$nome = "";
$nascimento = "";
$rg = "";
$cpf = "";
$endereco = "";
$numero = "";
$complemento = "";
$celular = "";
$datacadastro = date('d/m/Y');
$numeroconsultas = 0;
$ultPagamento = "00/00/0000";

$termo = "";

$listaPacientesBusca = [];

$resultado = "";
$erros = [];

$listaEsperaBusca = [];


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

if (isset($_GET['msgget'])) {

    if ($_GET['msgget'] == 1) {
        $resultado = " <div class='alert alert-warning' role='alert'><span>Entrada deletada com sucesso!</span></div>";
    }

    if ($_GET['msgget'] == 2) {
        $resultado = " <div class='alert alert-warning' role='alert'><span>Saída deletada com sucesso!</span></div>";
    }
    if ($_GET['msgget'] == 3) {
        $resultado = " <div class='alert alert-success' role='alert'><span>Produto Cadastrado com sucesso!</span></div>";
    }

    if ($_GET['msgget'] == 4) {
        $resultado = " <div class='alert alert-success' role='alert'><span>Produto Alterado com sucesso!</span></div>";
    }

    if ($_GET['msgget'] == 5) {
        $resultado = " <div class='alert alert-success' role='alert'><span>Fornecedor Cadastrado com sucesso!</span></div>";
    }

    if ($_GET['msgget'] == 6) {
        $resultado = " <div class='alert alert-success' role='alert'><span>Solicitação Cadastrada com sucesso!</span></div>";
    }
    if ($_GET['msgget'] == 7) {
        $resultado = " <div class='alert alert-success' role='alert'><span>Orgão Cadastrada com sucesso!</span></div>";
    }
    if ($_GET['msgget'] == 8) {
        $resultado = " <div class='alert alert-danger' role='alert'><span>Orgão Apagado com sucesso!</span></div>";
    }
    if ($_GET['msgget'] == 9) {
        $resultado = " <div class='alert alert-success' role='alert'><span>Funcionário Cadastrado com sucesso!</span></div>";
    }

    if ($_GET['msgget'] == 10) {
        $resultado = " <div class='alert alert-danger' role='alert'><span>Funcionário Apagado com sucesso!</span></div>";
    }

    if ($_GET['msgget'] == 11) {
        $resultado = " <div class='alert alert-danger' role='alert'><span>Fornecedor Apagado com sucesso!</span></div>";
    }
}

if (filter_input(INPUT_POST, "btnSubmit", FILTER_SANITIZE_STRING)) {

    $erros = Validar();

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

        $paciente->setNome($nome);
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


        if ($pacienteController->Cadastrar($paciente)) {

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
            $datacadastro = "";
            $status = "";

            $cod = $pacienteController->RetornarUltimoPaciente();

            $resultado = " <div class='alert alert-success' role='alert'><span>Paciente cadastrado com sucesso!</span> <a href='?pagina=visualizar&cod=$cod'> Clique aqui para Visualizar Dados</a> </div>";
        } else {

            $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um erro ao cadastrar paciente!</span> </div>";
        }
    }
}

function Validar() {
    $listaErros = [];

    $pacienteController = new PacienteController();


    if (strlen(filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING)) < 1) {
        $listaErros[] = "- Nome inválido.";
    }

    if (strlen(filter_input(INPUT_POST, "txtNascimento", FILTER_SANITIZE_STRING)) < 10) {
        $listaErros[] = "- Data de Nascimento inválida. (min. 10 caracteres)";
    }

    if (strlen(filter_input(INPUT_POST, "txtRg", FILTER_SANITIZE_STRING)) < 9) {
        $listaErros[] = "- Rg inválido. (min. 9 caracteres)";
    }

    if (!filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
        if (strlen(filter_input(INPUT_POST, "txtCpf", FILTER_SANITIZE_STRING)) == 14) {
            if ($pacienteController->VerificaCPFExiste(filter_input(INPUT_POST, "txtCpf", FILTER_SANITIZE_STRING)) == 1) {
                $listaErros[] = "- CPF já cadastrado.";
            }
        } else {
            $listaErros[] = "- CPF inválido.";
        }
    }

    if (strlen(filter_input(INPUT_POST, "txtRua", FILTER_SANITIZE_STRING)) < 5) {
        $listaErros[] = "- Endereço inválido.";
    }

    if (strlen(filter_input(INPUT_POST, "txtNumero", FILTER_SANITIZE_STRING)) < 1) {
        $listaErros[] = "- Digite o número do seu endereço.";
    }

    if (strlen(filter_input(INPUT_POST, "txtCelular", FILTER_SANITIZE_STRING)) < 11) {
        $listaErros[] = "- Celular inválido.";
    }

    return $listaErros;
}

if (filter_input(INPUT_POST, "btnCadastrarOrca", FILTER_SANITIZE_STRING)) {
    $cod_paciente = filter_input(INPUT_POST, "txtCodPaciente", FILTER_SANITIZE_NUMBER_INT);
    $codF = (int) $_SESSION['codF'];

    $data_hoje2 = date('d/m/Y');

    $t = explode("/", $data_hoje2);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];


    $orcamento = new Orcamento();
    $orcamento->setStatus(1);
    $orcamento->setUsuario($cod_paciente);
    $orcamento->setDia($dia);
    $orcamento->setMes($mes);
    $orcamento->setAno($ano);
    $orcamento->setFunc($codF);

    if ($orcamentoController->Cadastrar($orcamento)) {
        //$resultado = " <div class='alert alert-success' role='alert'><span>Orçamento cadastrado com sucesso!</span> </div>";
        header("location: painel.php?pagina=consulta");
    } else {
        $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um herro ao cadastrar novo Orçamento!</span> </div>";
    }
}


if (filter_input(INPUT_POST, "btnPagarParcela", FILTER_SANITIZE_STRING)) {
    $cod = filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT);

    $movimentopacController->Pagar(1, $cod);

    //header("location: painel.php?pagina=visualizar&cod=" . $_GET['cod'] . "&outros");
    $resultado = "<div class='alert alert-success'>Parcela paga com sucesso</div>";
}

if (filter_input(INPUT_POST, "bntGerarBoletos", FILTER_SANITIZE_STRING)) {

    $i = 1;
    $mesatual = date('m');
    $anoatual = date('Y');

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
        $movimentopac->setDia($dia);
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


if (filter_input(INPUT_POST, "btnEnviar", FILTER_SANITIZE_STRING)) {
    $termo = filter_input(INPUT_POST, "txtTermo", FILTER_SANITIZE_STRING);
    $listaPacientesBusca = $pacienteController->RetornarPacientes($termo, 1, 1);
} else {
    $listaPacientesBusca = $pacienteController->RetornarPacientes($termo, 4, 1);
}
echo $resultado;

if ($erros != NULL) {
    ?>
    <div class="linha" style="margin-left: 10px;">
        <div class="grid-100 coluna">
            <ul style="list-style: none;" class="alert alert-danger">
                <?php
                foreach ($erros as $e) {
                    ?>
                    <li><?= $e; ?></li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
    <?php
}

if (!isset($_GET['entradas']) && !isset($_GET['saidas']) && !isset($_GET['cod']) && !isset($_GET['solicitacoes']) && !isset($_GET['fornecedores']) && !isset($_GET['funcionarios']) && !isset($_GET['orgaos']) && !isset($_GET['pacientes'])) {

//$termo = "";
//$tipo = 3;
//$status = 1;
//$listaEntradasAberta = $entradasController->RetornarEntradas($termo, $tipo, $status);
//if ($listaEntradasAberta != null) {
//  foreach ($listaEntradasAberta as $user4) {
//  }
//}
}
?>
<div class="row">
    <div class="col-12 col-md-2">
        <div class="list-group">
            <a href="painel.php" class="list-group-item list-group-item-action <?php
            if (!isset($_GET['espera']) && !isset($_GET['historico']) && !isset($_GET['agenda']) && !isset($_GET['financeiro'])) {
                echo 'active';
            }
            ?>">Pacientes</a>

            <a href="painel.php?&espera" class="list-group-item list-group-item-action <?php
            if (isset($_GET['espera'])) {
                echo 'active';
            }
            ?>">Lista de Espera</a>


        </div>
    </div>
    <div class="col-12 col-md-10">
        <?php
        if (!isset($_GET['espera']) && !isset($_GET['historico']) && !isset($_GET['cod']) && !isset($_GET['agenda']) && !isset($_GET['financeiro'])) {
            ?>
            <div class="row" style="margin:5px;"> 
                <a target="" href="" class="btn btn-outline-success badge-pill" data-toggle="modal" data-target="#exampleModal4">Novo Pacienteeeeee</a>
            </div>
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" name="frmCadastro" id="frmCadastro" novalidate enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-9 col-md-9">
                                    <input type="text" class="form-control" id="txtTermo" name="txtTermo" value="<?= $termo; ?>" placeholder="Digite o nome do Cliente..." autofocus="">
                                </div>
                                <div class="col-3 col-md-3">
                                    <input style="width: 100%;" type="submit" class="btn btn-primary mb-2" name="btnEnviar" id="btnEnviar" value="Pesquisar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <?php
                                if ($listaPacientesBusca != NULL) {
                                    foreach ($listaPacientesBusca as $pacientes1) {
                                        $listaOrcamentosMes = $orcamentoController->RetornarOrcamentosConsulta(1, $pacientes1->getId(), $mes_hoje, $ano_hoje);
                                        $cont = 0;
                                        $ultpagamento = "";
                                        $dataatraso = "";
                                        if ($listaOrcamentosMes != null) {
                                            foreach ($listaOrcamentosMes as $contadordeorcamento) {
                                                $cont++;
                                            }
                                        }

                                        $listamovimentosultpag = $movimentopacController->RetornarUltPag($pacientes1->getId());
                                        //var_dump($listamovimentosultpag);
                                        if ($listamovimentosultpag != null) {
                                            foreach ($listamovimentosultpag as $ultpag) {
                                                $ultpagamento = $ultpag->getDia() . '/' . $ultpag->getMes() . '/' . $ultpag->getAno();
                                            }
                                        }
                                        $listamovimentoatraso = $movimentopacController->RetornarAtraso($pacientes1->getId());
                                        //var_dump($listamovimentosultpag);
                                        if ($listamovimentoatraso != null) {
                                            foreach ($listamovimentoatraso as $atraso) {
                                                $cod_paga = $atraso->getCod();
                                                $dataatraso = $atraso->getDia() . '/' . $atraso->getMes() . '/' . $atraso->getAno();
                                            }
                                        }
                                        ?>
                                        <div class="card" style="margin-bottom: 5px;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 col-md-6">
                                                        <b>Nome: </b><small style="color: blue;"><?= $pacientes1->getNome(); ?></small></br>
                                                        <b>Celular: </b><small style="color: blue;"><?= $pacientes1->getCelular(); ?></small>
                                                    </div>
                                                    <div class="col-6 col-md-6">
                                                        <b>Consultas Disponíveis: </b><small style="color: blue;"><?php
                                                            if ($cont < 4) {
                                                                echo 4 - $cont;
                                                            } else {
                                                                echo "<div class='alert alert-danger'>nº máximo de consultas atingindo!</div>";
                                                            }
                                                            ?></small></br>
                                                        <?php if ($listamovimentosultpag != null) { ?>
                                                            <b>Último Pagamento: </b><small style="color: blue;"><?= $ultpagamento; ?></small>
                                                        <?php } ?>
                                                    </div>

                                                    <div class="col-6 col-md-6" style="text-align: center; margin-top: 10px;">
                                                        <a style="margin-top: 10px;" target="" href="?pagina=visualizar&cod=<?= $pacientes1->getId() ?>" class="btn btn-outline-info badge-pill">Ver Tudo</a>
                                                        <a style="margin-top: 10px;" target="" href="Calendario/CalendarioView.php?cod=<?= $pacientes1->getId(); ?>" class="btn btn-outline-secondary badge-pill">Agendar</a>
                                                    </div>
                                                    <div class="col-6 col-md-6" style="text-align: center; margin-top: 10px;">
                                                        <div class="row" style="margin-top: 10px;">
                                                            <?php
                                                            $listamovimentosPac = $movimentopacController->RetornarPac($pacientes1->getId(), 2);
                                                            //  var_dump($listamovimentosPac);

                                                            if ($listamovimentosPac != null) {
                                                                if ($cont < 4) {
                                                                    ?>
                                                                    <form method="post" name="frmCadastro" id="frmCadastro" novalidate enctype="multipart/form-data">
                                                                        <input type="hidden" name="txtCodPaciente" id="txtCodPaciente" value="<?= $pacientes1->getId(); ?>" >
                                                                        <input type="submit" class="btn btn-outline-primary badge-pill" name="btnCadastrarOrca" id="btnCadastrarOrca" value="Nova Consulta">                                                        </form>
                                                                    </form>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:left; margin-left: 5px;">
                                                                    <input  type="hidden" value="<?= $cod_paga; ?>" id="txtCod" name="txtCod" />
                                                                    <input type="submit" class="btn btn-outline-success badge-pill" name="btnPagarParcela" id="btnPagarParcela" value="Pagar Parcela: <?= $dataatraso; ?>">                                                        </form>
                                                                </form>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center;"  >
                                                                    <input  type="hidden" value=" <?= $pacientes1->getId(); ?>" id="txtCod" name="txtCod" />
                                                                    <input  type="submit" value="Gerar Vínculo" class="btn btn-outline-success badge-pill" style="width: 100%;" name="bntGerarBoletos" />
                                                                </form>                
                                                                <?php
                                                            }
                                                            $diaatual = date('d');
                                                            $mesatual = date('m');
                                                            $anoatual = date('Y');
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12" style="text-align: center; margin-top: 10px;">
                                                        <?php
                                                        if ($pacientes1->getStatus() == 1) {
                                                            if ($listamovimentoatraso != null) {
                                                                foreach ($listamovimentoatraso as $user4) {
                                                                    if ($anoatual == $user4->getAno()) {
                                                                        $diferenca = $mesatual - $user4->getMes();
                                                                        if ($diferenca < 0) {
                                                                            ?>
                                                                            <div style="" class="alert alert-success alert-dismissible fade show" role="alert">
                                                                                <b>Paciente com suas contas em dia. Apto para Consulta</b>
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <?php
                                                                            if ($pacientes1->getStatus() == 2) {
                                                                                ?>
                                                                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                                                    <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                                                                    <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                                                                </form>
                                                                                <?php
                                                                            } else if ($pacientes1->getStatus() == 3) {
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
                                                                            <div style="" class="alert alert-success alert-dismissible fade show" role="alert">
                                                                                <b>Paciente com suas contas em dia. Apto para Consulta</b>
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <?php
                                                                            if ($pacientes1->getStatus() == 2) {
                                                                                ?>
                                                                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                                                    <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                                                                    <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                                                                </form>
                                                                                <?php
                                                                            } else if ($pacientes1->getStatus() == 3) {
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
                                                                                    <b>Paciente com suas contas em dia. Apto para Consulta</b>
                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                    <?php
                                                                                    if ($pacientes1->getStatus() == 2) {
                                                                                        ?>
                                                                                        <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                                                            <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                                                                            <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                                                                        </form>
                                                                                        <?php
                                                                                    } else if ($pacientes1->getStatus() == 3) {
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
                                                                                <b>Paciente com suas contas em dia. Apto para Consulta</b>
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                                <?php
                                                                                if ($pacientes1->getStatus() == 2) {
                                                                                    ?>
                                                                                    <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                                                        <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                                                                        <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                                                                    </form>
                                                                                    <?php
                                                                                } else if ($pacientes1->getStatus() == 3) {
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
                                                        } else if ($pacientes1->getStatus() == 2) {

                                                            if ($listamovimentoatraso != null) {
                                                                foreach ($listamovimentoatraso as $user4) {

                                                                    if ($anoatual == $user4->getAno()) {

                                                                        $diferenca = $mesatual - $user4->getMes();
                                                                        if ($diferenca < 0) {
                                                                            ?>
                                                                            <div style="" class="alert alert-success alert-dismissible fade show" role="alert">
                                                                                <b>Paciente com suas contas em dia. Apto para Consulta</b>
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <?php
                                                                            if ($pacientes1->getStatus() == 2) {
                                                                                ?>
                                                                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                                                    <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                                                                    <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                                                                </form>
                                                                                <?php
                                                                            } else if ($pacientes1->getStatus() == 3) {
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
                                                                            <div style="" class="alert alert-success alert-dismissible fade show" role="alert">
                                                                                <b>Paciente com suas contas em dia. Apto para Consulta</b>
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <?php
                                                                            if ($pacientes1->getStatus() == 2) {
                                                                                ?>
                                                                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                                                    <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                                                                    <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                                                                </form>
                                                                                <?php
                                                                            } else if ($pacientes1->getStatus() == 3) {
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
                                                                                    <b>Paciente com suas contas em dia. Apto para Consulta</b>
                                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>

                                                                                    <?php
                                                                                    if ($pacientes1->getStatus() == 2) {
                                                                                        ?>
                                                                                        <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                                                            <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                                                                            <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                                                                        </form>
                                                                                        <?php
                                                                                    } else if ($pacientes1->getStatus() == 3) {
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
                                                                                <b>Paciente com suas contas em dia. Apto para Consulta</b>
                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                                <?php
                                                                                if ($pacientes1->getStatus() == 2) {
                                                                                    ?>
                                                                                    <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center; margin-left: 5px;">
                                                                                        <input  type="hidden" value="<?= $cod_pacH; ?>" id="txtCod" name="txtCod" />
                                                                                        <input  type="submit" value="Habilitar Paciente" class="btn btn-outline-success btn-lg" name="btnTrocaStatusH" />
                                                                                    </form>
                                                                                    <?php
                                                                                } else if ($pacientes1->getStatus() == 3) {
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
                                                        } else if ($pacientes1->getStatus() == 3) {
                                                            
                                                        }
                                                        ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    </ul>

                                    <?php
                                } else {
                                    ?>
                                    <div class='alert alert-warning'>Nenhum Paciente encontrado! Termo de Busca: <b><?= $termo; ?></b> </div>
                                    <?php
                                }
                                ?>

                            </div>         
                        </div>
                    </div>
                </div>
            </div>

        </div>
        ﻿<!-- Modal CLIENTES -->
        <div class="modal fade bd-example-modal-lg" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel4">Novo Paciente</h5>
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
                                            <div class="col-md-8 mb-12">
                                                <label for="txtNome">Nome:</label>
                                                <input type="text" class="form-control" id="txtNome" name="txtNome" placeholder="Digite o nome Completo" value="<?= $nome; ?>" required="">
                                            </div>
                                            <div class="col-md-4 mb-12">
                                                <label for="txtNascimento">Data Nascimento:</label>
                                                <input type="text" class="form-control" id="txtNascimento" name="txtNascimento" placeholder="10/09/1995" value="<?= $nascimento; ?>" required="">

                                            </div>
                                            <div class="col-md-6 mb-12">
                                                <label for="txtRg">RG:</label>
                                                <input type="text" class="form-control" id="txtRg"  name="txtRg" placeholder="Ex: 1234567-8" value="<?= $rg; ?>" required="">
                                            </div>
                                            <div class="col-md-6 mb-12">
                                                <label for="txtCpf2">CPF:</label>
                                                <input type="text" class="form-control" id="txtCpf" name="txtCpf" placeholder="Ex: 123.465.789-11" value="<?= $cpf; ?>" required="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-12">
                                                <label for="txtRua">Rua:</label>
                                                <input type="text" class="form-control" id="txtRua" name="txtRua" placeholder="Rua:.../Bairro:..." value="<?= $endereco; ?>" required="">
                                            </div>
                                            <div class="col-md-6 mb-12">
                                                <label for="txtNumero">nº:</label>
                                                <input type="text" class="form-control" id="txtNumero"  name="txtNumero" placeholder="Número do Endereço" value="<?= $numero; ?> " required="">
                                            </div>
                                            <div class="col-md-6 mb-12">
                                                <label for="txtComplemento">Complemento:</label>
                                                <input type="text" class="form-control" id="txtComplemento" name="txtComplemento" placeholder="Ponto de Referência" value="<?= $complemento; ?> " required="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-12">
                                                <label for="txtCelular">Celular:</label>
                                                <input type="text" class="form-control" id="txtCelular" name="txtCelular" placeholder="(XX)9XXXX-XXXX" value="<?= $celular; ?>" required="">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="txtData">Data de Cadastro</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="txtData" name="txtData" value="<?= $datacadastro; ?>" placeholder="Username" required="">
                                                </div>
                                            </div>

                                        </div>
                                        <hr class="mb-4">
                                        <input type="hidden" class="form-control" id="txtResidencial" name="txtResidencial" placeholder="" value="" required="">
                                        <input type="hidden" class="form-control" id="txtResponsavel" name="txtResponsavel" placeholder="" value="" required="">
                                        <input type="hidden" class="form-control" id="txtIndicacao" name="txtIndicacao" value="" placeholder="Username" required="">
                                        <input type="hidden" class="form-control" id="txtStatus" name="txtStatus" value="1" placeholder="Username" required="">
                                        <input type="hidden" class="form-control" id="txtDr" name="txtDr" value="" placeholder="Username" required="">
                                        <input style='background-color: #000; color:#ccc;' type="submit" name="btnSubmit" id="btnSubmit" value="Cadastrar"  class="btn btn-primary btn-lg btn-block" />

                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    if (isset($_GET['espera'])) {
        $listaEsperaBusca = $listaesperaController->RetornarListaEspera();
        ?>

        <div class="my-1 p-3 bg-white rounded box-shadow">
            <h6 class="border-bottom border-gray pb-2 mb-0">Lista de Espera</h6>
            <?php
            if ($listaEsperaBusca != null) {

                foreach ($listaEsperaBusca as $user2) {
                    ?>
                    <div class = "media text-muted pt-3">
                        <a href="painel.php?pagina=visualizar&cod=<?= $user2->getCod_paciente(); ?>&cod_lista=<?= $user2->getCod(); ?>" style="color: #000; text-decoration:none; ">

                            <img data-src = "holder.js/32x32?theme=thumb&amp;bg=007bff&amp;fg=007bff&amp;size=1" alt = "32x32" class = "mr-2 rounded" style = "width: 32px; height: 32px;" src = "data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2232%22%20height%3D%2232%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2032%2032%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_162f824d082%20text%20%7B%20fill%3A%23007bff%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A2pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_162f824d082%22%3E%3Crect%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22%23007bff%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2211.703125%22%20y%3D%2216.9984375%22%3E32x32%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered = "true">

                        </a>

                        <p class = "media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                            <a href="painel.php?pagina=visualizar&cod=<?= $user2->getCod_paciente(); ?>&cod_lista=<?= $user2->getCod(); ?>" style="color: #000;">
                                <strong class = "d-block text-gray-dark">@ <?php
                                    $cod_paciente2 = $user2->getCod_paciente();
                                    echo $nomepaciente3 = $pacienteController->RetornarNomePac($cod_paciente2);
                                    ?>  </strong>
                            </a>
                            <?= $user2->getData(); ?> 
                        </p>
                    </div>


                    <?php
                }
            }
            ?>

        </div>

        <?php
    }
    ?>       
</div>
</div>
