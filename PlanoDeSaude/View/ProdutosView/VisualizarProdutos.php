<?php
$erros = [];

require_once("../Model/Clientes.php");
require_once("../Model/Usuarios.php");
require_once("../Model/Notas.php");
require_once("../Model/Pedidos.php");
require_once("../Model/Pagamento.php");
require_once("../Model/PagParPro.php");
require_once ("../Model/Listaespera.php");
require_once ("../Model/Servicos.php");

require_once("../Controller/ClientesController.php");
require_once("../Controller/UsuariosController.php");
require_once("../Controller/MovimentoClientesController.php");
require_once("../Controller/NotasController.php");
require_once("../Controller/PedidosController.php");
require_once("../Controller/PagamentoController.php");
require_once("../Controller/PagParProController.php");
require_once("../Controller/ListaEsperaController.php");
require_once("../Controller/ServicoController.php");

date_default_timezone_set('America/Manaus');


$clientesController = new ClientesController();
$usuarioController = new UsuarioController();
$notasController = new NotasController();
$movimentoClientesController = new MovimentoClientesController();
$pagamentoController = new PagamentoController();
$pagparproController = new PagParProController();
$pedidosController = new PedidosController();
$servicosController = new ServicoController();
$PontosController = new ListaesperaController();



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

$listaClientesBusca = [];
$listaNotas = [];
$listaPagamentos = [];
$listaMovimentosClientes = [];
$listaPagParPro = [];
$listaClientesBuscaI = [];
$ListaPontos = [];
$id = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
$tipo = 1;
$listaNotas = $notasController->RetornarNotas($tipo, $id);
$ListaPontos = $PontosController->RetornarListaEspera($_GET['cod']);
//var_dump($ListaPontos);
if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
    $termo = "";
    $status = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
    $tipo = 2;
    $listaClientesBusca = $clientesController->RetornarClientes($termo, $tipo, $status);
//var_dump($listaPacientesBusca);
}

if (filter_input(INPUT_POST, "btnCadastrarOrca", FILTER_SANITIZE_STRING)) {
    $status = 1;
    $usuario1 = $id;
    $func = (filter_input(INPUT_POST, "txtFunc", FILTER_SANITIZE_NUMBER_INT));

    $data_hoje2 = date('d/m/Y');

    $t = explode("/", $data_hoje2);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];

    $notas = new Notas();
    $notas->setStatus($status);
    $notas->setUsuario($usuario1);
    $notas->setDia($dia);
    $notas->setMes($mes);
    $notas->setAno($ano);

    $notas->setFunc($func);

    if ($notasController->Cadastrar($notas)) {

        $resultado = " <div class='alert alert-success' role='alert'><span>Orçamento cadastrado com sucesso!</span> </div>";
        header("location: painel.php?pagina=notas");
    } else {
        $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um herro ao cadastrar novo Orçamento!</span> </div>";
    }
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
        $resultado = $pedidosController->AlterStatusTodos2($status, $esp_pro);

        $resultado = "<div class='alert alert-success' role='alert'><span>Pagamento Cadastrado com Sucesso</span> </div>";
    } else {
        $resultado = "<div class='alert alert-danger' role='alert'><span>Houve um erro ao cadastrar parcela</span> </div>";
    }
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
if (filter_input(INPUT_GET, "cod_lista", FILTER_SANITIZE_NUMBER_INT)) {
    $cod_lista = filter_input(INPUT_GET, "cod_lista", FILTER_SANITIZE_NUMBER_INT);
    $cod_pac = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);

    $apagareventolist = $listaesperaController->DeletarEspera($cod_lista);
    header("location: painel.php?pagina=visualizar&cod=$cod_pac");
//var_dump($listaPacientesBusca);
}
if (filter_input(INPUT_POST, "btnEnviar", FILTER_SANITIZE_STRING)) {
    $termo = filter_input(INPUT_POST, "txtCliente", FILTER_SANITIZE_STRING);
    $status = 1;
    $tipo = 4;
    $listaClientesBuscaI = $clientesController->RetornarClientes($termo, $tipo, $status);
}

if (filter_input(INPUT_POST, "btnAdicionar", FILTER_SANITIZE_STRING)) {

    $indicacao = filter_input(INPUT_POST, "txtIndicacao", FILTER_SANITIZE_NUMBER_INT);
    $id = $_GET['cod'];

    if ($clientesController->AlterIndicacao($indicacao, $id)) {
        $cod_pac = $indicacao;

        $dia = date('d');
        $mes = date('m');
        $ano = date('Y');

        $listaespera = new Listaespera();
        $listaespera->setCod_paciente($cod_pac);
        $listaespera->setDia($dia);
        $listaespera->setMes($mes);
        $listaespera->setAno($ano);


        if ($PontosController->Cadastrar($listaespera)) {
            header("Location: painel.php?pagina=visualizar&cod=$id");
        } else {
            $resultado = "Houve um erro ao cadastrar";
        }
//     header("Location: painel.php?pagina=visualizar&cod=$id");
    } else {
        $resultado = "Houve um erro ao cadastrar";
    }
}
if (filter_input(INPUT_POST, "btnCancelarI", FILTER_SANITIZE_STRING)) {

    $indicacao = 0;
    $id = $_GET['cod'];

    if ($clientesController->AlterIndicacao($indicacao, $id)) {
        header("Location: painel.php?pagina=visualizar&cod=$id");
    } else {
        $resultado = "Houve um erro ao cadastrar";
    }
//     header("Location: painel.php?pagina=visualizar&cod=$id");
}

if (filter_input(INPUT_POST, "btnEnviarMais", FILTER_SANITIZE_STRING)) {
    $ultimocod = filter_input(INPUT_POST, "txtCliente", FILTER_SANITIZE_NUMBER_INT);

    $dia = date('d');
    $mes = date('m');
    $ano = date('Y');

    $id = $_GET['cod'];
    $listaespera = new Listaespera();
    $listaespera->setCod_paciente($ultimocod);
    $listaespera->setDia($dia);
    $listaespera->setMes($mes);
    $listaespera->setAno($ano);


    if ($PontosController->Cadastrar($listaespera)) {
        header("Location: painel.php?pagina=visualizar&cod=$id");
    } else {
        $resultado = "Houve um erro ao cadastrar";
    }
}
if (filter_input(INPUT_POST, "btnEnviarMenos", FILTER_SANITIZE_STRING)) {
    $ultimocod = filter_input(INPUT_POST, "txtCliente", FILTER_SANITIZE_NUMBER_INT);
    $id = $_GET['cod'];
    if ($PontosController->DeletarEspera($ultimocod)) {
        header("Location: painel.php?pagina=visualizar&cod=$id");
    } else {
        $resultado = "Houve um erro ao DELETAR ponto";
    }
}

$nomeindd = "";
?>
<ul class = "nav nav-tabs">
    <li class = "nav-item">
        <a class = "nav-link <?php if (!isset($_GET['notas']) && !isset($_GET['financeiro']) && !isset($_GET['historico'])) { ?> active <?php } ?>" href = "?pagina=visualizar&cod=<?= $_GET['cod']; ?>">Início</a>
    </li>
    <li class = "nav-item">
        <a class = "nav-link <?php if (isset($_GET['notas'])) { ?> active <?php } ?> " href = "?pagina=visualizar&cod=<?= $_GET['cod']; ?>&notas">Notas</a>
    </li>
    <li class = "nav-item">
        <a class = "nav-link <?php if (isset($_GET['financeiro'])) { ?> active <?php } ?>" href = "?pagina=visualizar&cod=<?= $_GET['cod']; ?>&financeiro">Financeiro</a>
    </li>
    <li class = "nav-item">
        <a class = "nav-link <?php if (isset($_GET['historico'])) { ?> active <?php } ?>" href = "?pagina=visualizar&cod=<?= $_GET['cod']; ?>&historico">Histórico</a>
    </li>

</ul>

<?php
if (!isset($_GET['notas']) && !isset($_GET['financeiro']) && !isset($_GET['historico'])) {
    if ($listaClientesBusca != null) {
        foreach ($listaClientesBusca as $user) {
            ?>
            <div class="col-md-12 mb-3">
                <hr class="mb-4"> 
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h3 class="mb-3">Dados Pessoais
                        </h3>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="row">

                            <h3 class="mb-3">Pontuação: 
                                <?php
                                $cod_cli = $_GET['cod'];
                                $cont2 = 0;
                                if ($ListaPontos != null) {
                                    $cont2 = 0;
                                    foreach ($ListaPontos as $use2) {
                                        $cont2++;
                                        $ultimo_cod = $use2->getCod();
                                    }
                                }
                                echo "</br>";
                                ?>

                            </h3>
                            <form class="form-inline" name="form_filtro_cat" method="post">
                                <input type="hidden"  name="txtCliente" id="txtCliente" value="<?= $ultimo_cod; ?>">
                                <input type="submit" value="-" class="btn btn-outline-dark my-2 my-sm-0" name="btnEnviarMenos" id="btnEnviarMenos" />          
                            </form> 
                            <h3 style="margin: 5px;"> <?= $cont2; ?></h3>
                            <form class="form-inline" name="form_filtro_cat" method="post">
                                <input type="hidden"  name="txtCliente" id="txtCliente" value="<?= $cod_cli; ?>">
                                <input type="submit" value="+" class="btn btn-outline-dark my-2 my-sm-0" name="btnEnviarMais" id="btnEnviarMais" />
                            </form>

                        </div>
                    </div>
                </div> 
                <?php
                if ($user->getIndicacao() == null) {
                    ?>
                    <div class="card">
                        <div class="card-body">

                            <?PHP
                            if (filter_input(INPUT_POST, "btnEnviar", FILTER_SANITIZE_STRING)) {
                                ?>
                                <h4 style="color: #0062cc">Escolher Indicação</h4>
                                <div class="row" style="border: 1px solid #0062cc">
                                    <form class="form-inline" name="form_filtro_cat" method="post">
                                        <select class="custom-select d-block w-100" id="txtIndicacao" name="txtIndicacao" required="">
                                            <?php
                                            $cont = 0;
                                            if ($listaClientesBuscaI != null) {
                                                foreach ($listaClientesBuscaI as $use) {
                                                    ?>
                                                    <option value="<?= $use->getId(); ?>"> <?= $use->getNome(); ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <input type="submit" value="Adicionar" class="btn btn-outline-success my-2 my-sm-0" name="btnAdicionar" id="btnAdicionar" />
                                    </form>
                                </div>
                                <?php
                            } else {
                                ?>
                                <h4 style="color: #0062cc">Escolher Indicação</h4>
                                <div class="row" style="border: 1px solid #0062cc">
                                    <form class="form-inline" name="form_filtro_cat" method="post">
                                        <div class="form-group mb-12">
                                            <label for="staticEmail2" class="sr-only"></label>
                                            <input class="form-control" type="search" placeholder="Escolher Indicação" aria-label="Escolher Indicação" name="txtCliente" id="txtCliente" value="<?= $termo; ?>">
                                        </div>

                                        <input type="submit" value="Pesquisar" class="btn btn-outline-success my-2 my-sm-0" name="btnEnviar" id="btnEnviar" />
                                    </form>
                                    <form class="form-inline" name="form_filtro_cat" method="post" action="" style="margin-left: 5px;">
                                        <input type="submit" value="Cancelar" class="btn btn-outline-success my-2 my-sm-0" name="btnCancelarI" id="btnCancelarI" />
                                    </form>
                                </div>

                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?PHP
                } else {
                    if ($user->getIndicacao() == 0) {
                        $nomeindd = "";
                    } else {
                        $nomeindd = $clientesController->RetornarNomeClientes($user->getIndicacao());
                    }
                }
                ?>
                <!-- Button trigger modal -->
            </div>

            <?php
            echo $resultado;
            ?>
            </div>
            <div class="col-12 col-md-12">
                <div class="row">
                    <div class="col-12 col-md-12" style="margin-bottom: 10px;">
                        <div class="card">
                            <div class="card-body">
                                <small style="color:green;">Nome:</small>
                                <?= $user->getNome(); ?>.
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
                            <small style="color:green;">Celular/Whatasapp:</small>
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
                                    <small style="color:green;">Data Nascimento:</small>
                                    <?= $user->getNascimento(); ?>.
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="col-12 col-md-6" style="margin-bottom: 10px;">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-body">
                                    <small style="color:green;">Indicação:</small>
                                    <?= $nomeindd ?>.
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-12 mb-3" >
                        <div class="card">
                            <div class="card-body">
                                <small style="color:blue;">Data de Cadastro: </small>
                                <small style="color:green;"><?= $user->getData(); ?> </small>
                                <small style="color:red;">--</small>

                            </div>
                        </div> 
                    </div>
                </div>


            </div>
            <small class = "d-block text-right mt-3" style="position: relative; right: 10px; font-size: 14pt;">
                <a target="_blank" href ="../Impressoes/VisualizarClientesIMPRE.php?cod=<?= $id; ?>">Imprimir Dados</a>
            </small>
            <small class = "d-block text-right mt-3" style="position: relative; right: 10px; font-size: 14pt;">
                <a href = "painel.php?pagina=clientes&cod=<?= $user->getId(); ?>">Editar Dados</a>
            </small>
            <?php
        }
    }
//var_dump($listaAnamnesesBusca);
}
if (isset($_GET['notas'])) {
    ?>
    <div class="row" style="margin-top: 10px;">
        <div class="col-6 col-md-4">
            <div class="card">
                <div class="card-header" style="background-color: #000; color: #fff;">
                    <b>Notas</b>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Iniciar pedido</h5>
                    <p class="card-text">
                    <form method="post" name="frmCadastro" id="frmCadastro" novalidate enctype="multipart/form-data">
                        <?php
                        $termo = "";
                        $tipo = 1;
                        $status = 1;

                        $listaUsuariosBusca2 = $usuarioController->RetornarUsuarios($termo, $tipo, $status);
                        ?>
                        <div class="col-sm-12">
                            <div class="form-group label-floating">
                                <input  type="hidden" id="txtFunc" name="txtFunc" required="" value="<?= (int) $_SESSION['codF']; ?>">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12" style="width: 100%; text-align: right;">
                            <button type="submit" class="btn btn-dark" name="btnCadastrarOrca" id="btnCadastrarOrca" value="Cadastrar"> Clique aqui</button>
                        </div>
                    </form>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-8 col-md-8">


            <?php
            if ($listaNotas != null) {
                foreach ($listaNotas as $user4) {
                    $id2 = $user4->getCod();
                    ?>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" colspan="2" style="text-align: center;">Descrição: Nota: nº <?= $user4->getCod(); ?></th>
                                <th scope="col" colspan="2" style="text-align: center;">Data: <?= $user4->getDia(); ?>/<?= $user4->getMes(); ?>/<?= $user4->getAno(); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" style="text-align: center;"> 
                                    <a style=""  class="btn btn-outline-dark btn-lg" href="?pagina=notas&cod=<?= $user4->getCod(); ?>" role="button"><i class="material-icons">call_missed_outgoing</i>Ir</a>
                                    <a class = "btn btn-outline-dark btn-lg"  target="blank"  href="../Impressoes/pdf2.php?cod=<?= $user4->getCod(); ?> "><i class="material-icons">format_paint</i>Imprimir</a>
                                    <a class = "btn btn-outline-dark btn-lg"  href = "#"  data-toggle="collapse" data-target="#collapseTwo<?= $user4->getCod(); ?>" aria-expanded="false" aria-controls="collapseTwo<?= $user4->getCod(); ?>"  href="../Impressoes/pdf2.php?cod=<?= $user4->getCod(); ?> "><i class="material-icons">monetization_on</i>Pagamento</a>

                                    <div id="collapseTwo<?= $user4->getCod(); ?>" class="collapse" aria-labelledby="headingTwo<?= $user4->getCod(); ?>" data-parent="#accordion">
                                        <div class="card-body">
                                            <table class="table table-bordered" style="margin-top: 10px;">
                                                <thead class="thead-dark">
                                                <th>Valor</th>
                                                <th>Troco</th>
                                                <th></th>
                                                </thead>
                                                <?php
                                                $id2 = $user4->getCod();
                                                $cod_func = $user4->getFunc();
                                                $listaPagamentos = $movimentoClientesController->RetornarPagamentos3($id2);
                                                if ($listaPagamentos != null) {
                                                    foreach ($listaPagamentos as $user5) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                if ($user5->getTipo() != 3) {
                                                                    $cod_pac = $user5->getCod();
                                                                    $pontos = ',';
                                                                    $valor_completo = $user5->getTotal();
                                                                    $valor_parcela = $user5->getTotal();
                                                                    $result = str_replace($pontos, "", $valor_completo);
                                                                    $valor_completo = (float) $result;

                                                                    $valor_completo = number_format($valor_completo, 2, ',', '.');
                                                                } else {
                                                                    $valor_parcela = $user5->getTotal();
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($user5->getTipo() == 2) {
                                                                    $qtdparcela = $user5->getNumparcelas();
                                                                } else {
                                                                    $qtdparcela = 1;
                                                                }
                                                                ?>
                                                                <?PHP
                                                                $pontos = ',';
                                                                $result = str_replace($pontos, "", $valor_parcela);
                                                                $valor_parcela = (float) $result;
                                                                $totaltotal = ($qtdparcela) * ($valor_parcela);
                                                                $totaltotal = number_format($totaltotal, 2, ',', '.');


                                                                $result2 = str_replace($pontos, "", $user5->getGorjeta());
                                                                $gorjeta = (float) $result2;
                                                                $gorjeta = number_format($gorjeta, 2, ',', '.');
                                                                ?>
                                                                R$ <?= $totaltotal; ?>
                                                            </td>
                                                            <td>
                                                                R$ <?= $gorjeta; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $nomebarbeiro = $usuarioController->RetornarNomeUsuarios($cod_func); ?> 
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </table>

                                        </div>
                                    </div>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                }
            }
            ?>

        </div>
    </div>



    <?php
}
if (isset($_GET['financeiro'])) {
    ?>
    <table class="table table-bordered" style="margin-top: 10px;">
        <thead class="thead-dark">
        <th>Descrição</th>
        <th>Valor</th>
        <th>Data</th>
       
        <th>#</th>
    </thead>
    <?php
    if ($listaNotas != null) {
        foreach ($listaNotas as $user4) {
            $id2 = $user4->getCod();
            $cod_func = $user4->getFunc();
            $listaPagamentos = $movimentoClientesController->RetornarPagamentos3($id2);
            if ($listaPagamentos != null) {
                foreach ($listaPagamentos as $user5) {
                    ?>
                    <tr>
                        <td>
                            Nota: nº <?= $user4->getCod(); ?>
                        </td>
                        <td>
                            <?php
                            if ($user5->getTipo() != 3) {
                                $cod_pac = $user5->getCod();
                                $pontos = ',';
                                $valor_completo = $user5->getTotal();
                                $valor_parcela = $user5->getTotal();
                                $result = str_replace($pontos, "", $valor_completo);
                                $valor_completo = (float) $result;

                                $valor_completo = number_format($valor_completo, 2, ',', '.');
                            } else {
                                $valor_parcela = $user5->getTotal();
                            }
                            ?>
                            <?php
                            if ($user5->getTipo() == 2) {
                                $qtdparcela = $user5->getNumparcelas();
                            } else {
                                $qtdparcela = 1;
                            }
                            ?>
                            <?PHP
                            $pontos = ',';
                            $result = str_replace($pontos, "", $valor_parcela);
                            $valor_parcela = (float) $result;
                            $totaltotal = ($qtdparcela) * ($valor_parcela);
                            $totaltotal = number_format($totaltotal, 2, ',', '.');
                            ?>
                            Total: R$ <?= $totaltotal; ?>
                        </td>
                        <td>
                            Data:  <?= $user5->getDia() . '/' . $user5->getMes() . '/' . $user5->getAno(); ?> 
                        </td>
                       
                        <td style="text-align: center;">
                            <a class = "btn btn-outline-dark btn-lg"  target="blanck"  href ="../Impressoes/NotasFINIMPRE.php?cod=<?= $id2; ?>"><i class="material-icons">format_paint</i>Imprimir</a>
                        </td>
                    </tr>
                    <?php
                }
            }
        }
    }
    ?>
    </table>
    <?php
}
if (isset($_GET['historico'])) {
    echo "historico";
}
?>

<style>
    #eusouomestre:hover{
        color:#fff;
    }
</style>

<!-- Modal -->
