<?php
$erros = [];

require_once("Model/Paciente.php");
require_once("Model/Orcamento.php");
require_once("Model/Procedimento.php");
require_once ("Model/Servico.php");
require_once ("Model/Dente.php");
require_once("Controller/PacienteController.php");
require_once("Controller/OrcamentoController.php");
require_once("Controller/ProcedimentoController.php");
require_once("Controller/ServicoController.php");
require_once("Controller/DenteController.php");
require_once ("Controller/CategoriaSerFinController.php");
require_once ("Model/CategoriaSerFin.php");


$categoriaserfinController = new CategoriaSerFinController();
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
$ListaCategoriass = [];
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

$ListaCategorias = $categoriaserfinController->RetornarCategorias();
$listadentes = $denteController->RetornarDentes();


if (filter_input(INPUT_POST, "btnFinalizarConsulta", FILTER_SANITIZE_STRING)) {
    $cod = filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT);

    $procedimentoController->AlterStatusTodos2(2, $cod);
    $orcamentoController->AlterStatusTodos(2, $cod);

    header("location: painel.php?pagina=consulta&cod=$cod");
}



if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
    $id = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
    $tipo = 2;
    $listaOrcamentos = $orcamentoController->RetornarOrcamentos($tipo, $id);
} else {
    $cod_cadastrador = $_SESSION['codF'];
    $listaOrcamentos = $orcamentoController->RetornarUltimoOrcamento($cod_cadastrador);
}


if (filter_input(INPUT_POST, "btnCadastrarProcedimento", FILTER_SANITIZE_STRING)) {
    $dente = filter_input(INPUT_POST, "txtDente", FILTER_SANITIZE_NUMBER_INT);
    $servico = filter_input(INPUT_POST, "txtServico", FILTER_SANITIZE_NUMBER_INT);
    $nota = filter_input(INPUT_POST, "txtNota", FILTER_SANITIZE_NUMBER_INT);
    $valor = filter_input(INPUT_POST, "txtValor", FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, "txtStatus", FILTER_SANITIZE_NUMBER_INT);
    $categoria2 = filter_input(INPUT_POST, "txtCategoria", FILTER_SANITIZE_NUMBER_INT);

    $nivel = 1;
    $tipo = 1;
    $obs = filter_input(INPUT_POST, "txtObs", FILTER_SANITIZE_STRING);


//    $pontos = ',';
//    $result = str_replace($pontos, "", $valor);
    $valor = (float) $valor;
    $valor = number_format($valor, 2, '.', ',');

    $data = date('d/m/Y');
    $t = explode("/", $data);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];


    $procedimento = new Procedimento();
    $procedimento->setDente($dente);
    $procedimento->setServico($servico);
    $procedimento->setUsuario($nota);
    $procedimento->setValor($valor);
    $procedimento->setStatus($status);
    $procedimento->setNivel($nivel);
    $procedimento->setObs($obs);
    $procedimento->setTipo($tipo);
    $procedimento->setDia($dia);
    $procedimento->setMes($mes);
    $procedimento->setAno($ano);
    $procedimento->setCategoria($categoria2);

    if ($procedimentoController->Cadastrar($procedimento)) {
        $resultado = " <div class='alert alert-success' role='alert'><span>Procedimento cadastrado com sucesso! </span> </div>";
    } else {
        $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um herro ao cadastrar novo Procedimento!</span> </div>";
    }
}

if (filter_input(INPUT_POST, "btnApagar", FILTER_SANITIZE_STRING)) {
    $cod = filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT);
    if ($procedimentoController->Deletar2($cod)) {
        header('Location: painel.php?pagina=orcamento');
    } else {
        $resultado = "Houve um erro ao apagar";
    }
}





if (filter_input(INPUT_POST, "btnApagarOrcamento", FILTER_SANITIZE_STRING)) {
    $cod = filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT);
    $orcamentoController->Deletar($cod);
    $procedimentoController->DeletarO($cod);
    header('Location: painel.php?');
}

if (filter_input(INPUT_POST, "btnFinalizar", FILTER_SANITIZE_STRING)) {
    $cod = filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT);
    $codor = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
    if ($procedimentoController->AlterStatusTodos2(2, $cod)) {
        header("location: painel.php?pagina=orcamento&cod=$codor");
    } else {
        $resultado = "Houve um erro ao cadastrar";
    }
}

if (filter_input(INPUT_POST, "btnCancelar", FILTER_SANITIZE_STRING)) {

    $cod = filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT);
    $codor = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);

    if ($procedimentoController->AlterStatusTodos2(0, $cod)) {

        header("location: painel.php?pagina=orcamento&cod=$codor");
    } else {
        $resultado = "Houve um erro ao cancelar";
    }
}

if (filter_input(INPUT_POST, "btnEnviar2", FILTER_SANITIZE_STRING)) {
    $termo = filter_input(INPUT_POST, "txtProduto", FILTER_SANITIZE_STRING);
    $cod_categoria = filter_input(INPUT_POST, "txtCat", FILTER_SANITIZE_NUMBER_INT);
    $listaServicos = $servicoController->RetornarServicosPorCat($cod_categoria, $termo);
    //var_dump($listaServicos);
} else {
    $termo = "";
    $tipo = 2;
    $cod_categoria = 1;
    $listaServicos = $servicoController->RetornarServicosPorCat($cod_categoria, $termo);
    //var_dump($listaServicos);
}

//var_dump($listaOrcamentos);
if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
    if ($listaOrcamentos != null) {
        foreach ($listaOrcamentos as $user4) {
            $o = $user4->getCod();
            $termo = "Nós é zika irmão";
            $tipo = 1;
            $status = $o;
            $listaProcedimentos = $procedimentoController->RetornarProcedimentos($termo, $tipo, $status);
            ?>
            <div class="jumbotron" style="text-align: center; ">
                <p class="alert alert-info">Visualize os procedimentos da consulta ou você pode voltar para página do paciente clicando abaixo.</p>
                <?php
                if ($user4->getStatus() == 2) {
                    $codor = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
                    ?>
                    <a class="btn btn-outline-secondary btn-lg" href="painel.php?pagina=visualizar&cod=<?= $user4->getUsuario(); ?>&consultas" role="button">Voltar</a>
                    <?php
                }
                ?>

            </div>
            <table class = "table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="4" style="text-align: center; background-color: #0091ea; color: #fff;">Procedimentos</th>
                    </tr>
                </thead>
                <?php
                $cont = 0;
                if ($listaProcedimentos != null) {
                    foreach ($listaProcedimentos as $user4) {
                        $cont++;
                        $cod_proc = $user4->getCod();
                        $cod_dente = $user4->getDente();
                        $cod_servico = $user4->getServico();
                        $nivel = $user4->getNivel();
                        if ($nivel == 4)
                            $cor = "alert alert-danger";
                        if ($nivel == 3)
                            $cor = "alert alert-warning";
                        if ($nivel == 2)
                            $cor = "alert alert-info";
                        if ($nivel == 1)
                            $cor = "alert alert-success";

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

                        $obs = $user4->getObs();
                        $valor_procedimento = $user4->getValor();
                        $string = $valor_procedimento;
                        $stringCorrigida = str_replace(',', '', $string);

                        $valor_procedimento = number_format($stringCorrigida, 2, ',', '.');
                        $dia = $user4->getDia();
                        $mes = $user4->getMes();
                        $ano = $user4->getAno();
                        $listaDentes = $denteController->RetornarDentes2($cod_dente);
                        if ($listaDentes != null) {
                            foreach ($listaDentes as $user0) {
                                $cod_dente = $user0->getCod();
                                $nomed = $user0->getNome();
                                $descricaod = $user0->getDescricao();
                                $quadrante = $user0->getQuadrante();
                                $imagem = $user0->getImagem();
                            }
                        }
                        ?>
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
                            <td colspan="4" style="background-color: #fff;">
                                <div class="row" >
                                    <div class="col-12 col-md-6" style="margin-bottom: 10px;">
                                        <div class="card">
                                            <div class="card-body">
                                                <small style="color:green;">Dente:</small>
                                                <?= $descricaod . "/Quadrante: " . $quadrante; ?>.
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-12 col-md-6" style="margin-bottom: 10px;">
                                        <div class="card">
                                            <div class="card-body">
                                                <small style="color:green;">Serviço:</small>
                                                <?= $nome; ?>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                                        <div class="card">
                                            <div class="card-body">
                                                <small style="color:green;">Obs:</small>
                                                <?= $obs ?>
                                            </div>
                                        </div> 
                                    </div>
                                </div>

                            </td>

                        </tr>

                        <?php
                    }
                }
                ?>
            </table>

            <?php
        }
    } else {
        echo "<div class='alert alert-warning' role='alert'>Orçamento Fechado.</div>";
    }
} else {
    if ($listaOrcamentos != null) {
        foreach ($listaOrcamentos as $user4) {
            $o = $user4->getCod();
            $termo = "Nós é zika irmão";
            $tipo = 1;
            $status = $o;
            $listaProcedimentos = $procedimentoController->RetornarProcedimentos($termo, $tipo, $status);
            echo $resultado;
            ?>
            </br>
            <nav class="navbar navbar-expand-lg  navbar-dark bg-dark" style="background-color: #ccc; margin: -20px;">
                <a class="navbar-brand" href="#"><span class="oi oi-person"></span></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">
                    Opções <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent2">

                    </br>
                    <form  name="form_filtro_cat" method="post" action="" class="form-inline my-2 my-lg-0" >
                        <select  name="txtCat"  class="form-control" id="txtCat" style="margin: 10px; margin-right: 5px; height:50px;   font-size: 16pt; color:#000; " >
                            <?php
                            if ($ListaCategorias != null) {
                                foreach ($ListaCategorias as $FinanceiroCategorias) {
                                    ?>
                                    <option style="" value="<?= $FinanceiroCategorias->getId(); ?>"><?= $FinanceiroCategorias->getNome(); ?></option>         
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <input style="padding: 18px; height:50px; font-size: 14pt;"class="form-control mr-sm-2" type="search" placeholder="Serviço..." aria-label="Produto/Serviço" name="txtProduto" id="txtProduto">    
                        <input style="color:#fff; margin-left: 10px; margin-right: 10px; margin-top: 2px; "  type="submit" value="Pesquisar" class="btn btn-outline-secondary btn-lg" name="btnEnviar2" id="btnEnviar2" />
                    </form>
                    <ul class="navbar-nav mr-auto">
                        </br>
                        <li class="nav-item active">
                            <a class="btn btn-outline-success btn-lg" id="eusouomestre" style="color:#fff;"  role="button" data-toggle="modal" data-target="#exampleModal3">Procedimentos</a>
                        </li>

                        </br>
                        <form name="form_cadastrarmovimento" method="post" action="" style="text-align:left; margin-left: 5px;">
                            <input  type="hidden" value="<?= $o; ?>" id="txtCod" name="txtCod" />
                            <input  type="submit" value="Finalizar Consulta" class="btn btn-outline-info btn-lg" name="btnFinalizarConsulta" />
                        </form>

                        </br>
                        <form name="form_cadastrarmovimento" method="post" action="" style="text-align:left; margin-left: 5px;">
                            <input  type="hidden" value="<?= $o; ?>" id="txtCod" name="txtCod" />
                            <input  type="submit" value="Cancelar" class="btn btn-outline-danger btn-lg" name="btnApagarOrcamento" />
                        </form>
                    </ul>
                </div>
            </nav>
            </br>
            <div class="row">
                <?php
                if ($listaServicos != null) {
                    foreach ($listaServicos as $user) {
                        ?>  
                        <div class="col-6 col-md-3" style="">
                            <div class="card" >
                                <div class="card-body" >
                                    <div class="card" style="height: 170px; text-align:center; ">
                                        <div class="card-body">
                                            <small style="color:green; font-size: 12pt;"><?= $user->getNome(); ?> </small>
                                            </br>
                                            <small>Descrição:</small><small style="color:blue;"><?= $user->getDescricao(); ?> - </small>
                                            </br>
                                        </div>
                                    </div>
                                    <div class="card-header" id="headingTwo<?= $user->getCod(); ?>">
                                        <h5 class="mb-0">
                                            <button class="btn btn-outline-primary" style="width: 100%;" type="button" data-toggle="collapse" data-target="#collapseTwo<?= $user->getCod(); ?>" aria-expanded="false" aria-controls="collapseTwo<?= $user->getCod(); ?>">
                                                Ver(+)
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseTwo<?= $user->getCod(); ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">

                                        <div class="card">
                                            <div class="card-body">
                                                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:right;">
                                                    <div class="form-row">

                                                        <input type="hidden" name="txtServico" id="txtServico" value="<?= $user->getCod(); ?>">
                                                        <input type="hidden" name="txtNota" id="txtNotas" value="<?= $o; ?>">
                                                        <input type="hidden" name="txtStatus" id="txtStatus" value="3">
                                                        <input type="hidden" name="txtCategoria" id="txtCategoria" value="<?= $cod_categoria; ?>">
                                                        <input type="hidden" name="txtValor" id="txtValor" value="<?= number_format($user->getValor(), 2, ',', '.'); ?>">
                                                        <div class="form-group col-12 col-md-12" style="">
                                                            <small>Dente:</small>
                                                            <select  name="txtDente"  class="form-control" id="txtDente" style="color:#000;">
                                                                <?php
                                                                if ($listadentes != null) {
                                                                    foreach ($listadentes as $dente2) {
                                                                        ?>
                                                                        <option style="" value="<?= $dente2->getCod(); ?>"><?= $dente2->getNome(); ?> - <?= $dente2->getDescricao(); ?></option>         
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>

                                                        </div>
                                                        <div class="form-group col-12 col-md-12">
                                                            <small>Obs:</small><input class="form-control form-control-sm"   type="text" name="txtObs" id="txtObs" value="" placeholder="Obs...">
                                                        </div>
                                                        <input style="text-align: center; font-size: 10pt; width: 100%;"  type="submit" value="Pedir" class="btn btn-outline-dark btn-lg" name="btnCadastrarProcedimento" />

                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div> 
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <?PHP
        }
    } else {
        echo "<div class='alert alert-warning' role='alert'>Orçamento Fechado.</div>";
    }
}
?>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Lista de Procedimentos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr style="background-color: #0091ea; color: #fff;">
                            <th>
                                Dente
                            </th>
                            <th>
                                Serviço
                                </td>
                            <th>
                                Obs
                            </th>
                            <th>
                                #
                            </th>
                        </tr>
                    </thead>
                    <?php
                    $cont = 0;
                    if ($listaProcedimentos != null) {
                        foreach ($listaProcedimentos as $user4) {
                            $cont++;
                            $cod_proc = $user4->getCod();
                            $cod_dente = $user4->getDente();
                            $cod_servico = $user4->getServico();
                            $nivel = $user4->getNivel();
                            if ($nivel == 4)
                                $cor = "alert alert-danger";
                            if ($nivel == 3)
                                $cor = "alert alert-warning";
                            if ($nivel == 2)
                                $cor = "alert alert-info";
                            if ($nivel == 1)
                                $cor = "alert alert-success";

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

                            $obs = $user4->getObs();
                            $valor_procedimento = $user4->getValor();
                            $string = $valor_procedimento;
                            $stringCorrigida = str_replace(',', '', $string);

                            $valor_procedimento = number_format($stringCorrigida, 2, ',', '.');
                            $dia = $user4->getDia();
                            $mes = $user4->getMes();
                            $ano = $user4->getAno();
                            $listaDentes = $denteController->RetornarDentes2($cod_dente);
                            if ($listaDentes != null) {
                                foreach ($listaDentes as $user0) {
                                    $cod_dente = $user0->getCod();
                                    $nomed = $user0->getNome();
                                    $descricaod = $user0->getDescricao();
                                    $quadrante = $user0->getQuadrante();
                                    $imagem = $user0->getImagem();
                                }
                            }
                            ?>
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
                                <td>
                                    <?= $descricaod . "/Quadrante: " . $quadrante; ?>
                                </td>
                                <td>
                                    <?= $nome; ?>
                                </td>
                                <td>
                                    <?= $obs ?>
                                </td>
                                <td>
                                    <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center;"  >
                                        <input  type="hidden" value="<?= $cod_proc; ?>" id="txtCod" name="txtCod" />
                                        <input  type="submit" value="Excluir" class="btn btn-outline-danger btn-lg" name="btnApagar" />
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

