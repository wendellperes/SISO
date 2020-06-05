<?php
$erros = [];

require_once("../Model/Clientes.php");

require_once("../Controller/ClientesController.php");

$clientesController = new ClientesController();

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
$datacadastro = date('d/m/Y');
$status = "";

$resultado = "";

$listaClientesBusca = [];


if (filter_input(INPUT_POST, "btnSubmit", FILTER_SANITIZE_STRING)) {
    $erros = Validar();
    if (empty($erros)) {
        $clientes = new Clientes();
        $clientes->setNome(filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING));
        $clientes->setNascimento(filter_input(INPUT_POST, "txtDatanascimento", FILTER_SANITIZE_STRING));
        $clientes->setRg(filter_input(INPUT_POST, "txtRg", FILTER_SANITIZE_STRING));
        $clientes->setCpf(filter_input(INPUT_POST, "txtCpf", FILTER_SANITIZE_STRING));
        $clientes->setEndereco(filter_input(INPUT_POST, "txtRua", FILTER_SANITIZE_STRING));
        $clientes->setNumero(filter_input(INPUT_POST, "txtNumero", FILTER_SANITIZE_STRING));
        $clientes->setComplemento(filter_input(INPUT_POST, "txtComplemento", FILTER_SANITIZE_STRING));
        $clientes->setCelular(filter_input(INPUT_POST, "txtCelular", FILTER_SANITIZE_STRING));
        $clientes->setResidencial(filter_input(INPUT_POST, "txtResidencial", FILTER_SANITIZE_STRING));
        $clientes->setResponsavel(null);
        $clientes->setIndicacao(null);
        $clientes->setData($datacadastro);
        $clientes->setStatus(filter_input(INPUT_POST, "txtStatus", FILTER_SANITIZE_STRING));
        $dr = filter_input(INPUT_POST, "txtDr", FILTER_SANITIZE_STRING);
        $clientes->setDr($dr);



        if (!filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
            //Cadastrar
            if ($clientesController->Cadastrar($clientes)) {

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

                $resultado = " <div class='alert alert-success' role='alert'><span>Cliente cadastrado com sucesso!</span> </div>";
                header("location: painel.php?");
            } else {

                $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um erro ao cadastrar cliente!</span> </div>";
            }
        } else {
            //Editar
            $clientes->setId(filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT));
            $id = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);

            if ($clientesController->Alterar($clientes)) {
                $resultado = " <div class='alert alert-success' role='alert'><span>Dados do paciente alterado com sucesso!</span> <a href='painel.php?pagina=visualizar&cod=$id'>Clique aqui para Visualizar Dados</a> </div>";
            } else {
                $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um erro ao alterar dados do paciente!</span> </div>";
            }
        }
    }
}

function Validar() {
    $listaErros = [];

    $clientesController = new ClientesController();


    if (strlen(filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING)) < 1) {
        $listaErros[] = "- Nome inválido.";
    }

    if (strlen(filter_input(INPUT_POST, "txtRua", FILTER_SANITIZE_STRING)) < 5) {
        $listaErros[] = "- Endereço inválido.";
    }

    if (strlen(filter_input(INPUT_POST, "txtNumero", FILTER_SANITIZE_STRING)) < 1) {
        $listaErros[] = "- Digite o número do seu endereço.";
    }



    return $listaErros;
}

if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
    $termo = "";
    $status = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
    $tipo = 2;
    $listaClientesBusca = $clientesController->RetornarClientes($termo, $tipo, $status);
    //var_dump($listaClientesBusca);
}

if ($listaClientesBusca != null) {
    foreach ($listaClientesBusca as $user) {
        $cod = $user->getId();
        $nome = $user->getNome();
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
    <div class="container">
        <div class="row">   
            <div class="col-md-12 order-md-1">

                <form method="post" name="frmCadastro" id="frmCadastro" novalidate enctype="multipart/form-data">

                    <?php
                    echo $resultado;
                    ?>


                    <hr class="mb-4">  

                    <h4 class="mb-3">Dados Pessoais</h4>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="txtNome">Nome Completo:</label>
                            <input type="text" class="form-control" id="txtNome" name="txtNome" placeholder="" value="<?= $nome; ?>" required="">
                            <div class="invalid-feedback">
                                Nome requerido.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="txtRg">RG:<small style="color:#ccc;"> Ex:1234567-8</small></label>
                            <input type="text" class="form-control" id="txtRg"  name="txtRg" placeholder="" value="<?= $rg; ?>" required="">
                            <div class="invalid-feedback">
                                RG requerido.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="txtCpf2">CPF:<small style="color:#ccc;"> Ex:123.465.789-11</small></label>
                            <input type="text" class="form-control" id="txtCpf" name="txtCpf" placeholder="" value="<?= $cpf; ?>" required="">
                            <div class="invalid-feedback">
                                CPF requerido.
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">    
                    <h4 class="mb-3">Endereço</h4>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="txtRua">Rua:</label>
                            <input type="text" class="form-control" id="txtRua" name="txtRua" placeholder="" value="<?= $endereco; ?>" required="">
                            <div class="invalid-feedback">
                                Rua requerida.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="txtNumero">nº:</label>
                            <input type="text" class="form-control" id="txtNumero"  name="txtNumero" placeholder="" value="<?= $numero; ?> " required="">
                            <div class="invalid-feedback">
                                Nº requerido.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="txtComplemento">Complemento:</label>
                            <input type="text" class="form-control" id="txtComplemento" name="txtComplemento" placeholder="" value="<?= $complemento; ?> " required="">
                            <div class="invalid-feedback">
                                Complemento Requerido.
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">    
                    <h4 class="mb-3">Contato</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="txtCelular2">Celular:</label><SMALL style="color:#ccc"> Ex: (97)98100-0000</SMALL>
                            <input type="text" class="form-control" id="txtCelular" name="txtCelular" placeholder="(XX)9XXXX-XXXX" value="<?= $celular; ?> " required="">
                            <div class="invalid-feedback">
                                Celular requerido.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="txtResidencial">Whatsapp:</label><SMALL style="color:#ccc"> Ex: (97)98100-0000</SMALL>
                            <input type="text" class="form-control" id="txtResidencial" name="txtResidencial" placeholder="(XX)9XXXX-XXXX" value="<?= $residencial; ?>" required="">
                            <div class="invalid-feedback">
                                Residencial requerido.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="txtDatanascimento">Data Nascimento:</label><SMALL style="color:#ccc"> Ex: 10/09/1995</SMALL>
                            <input type="text" class="form-control" id="txtDatanascimento" name="txtDatanascimento" placeholder="dd/mm/AAAA" value="<?= $nascimento; ?>" required="">
                            <div class="invalid-feedback">
                                Responsável requerido.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="txtStatus">Status</label>
                            <select class="custom-select d-block w-100" id="txtStatus" name="txtStatus" required="">

                                <option value="1" <?= ($status == "1" ? "selected='selected'" : "") ?>>Ativo</option>
                                <option value="0" <?= ($status == "0" ? "selected='selected'" : "") ?>>Inativo</option>

                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>

                    </div>
                    <hr class="mb-4">   

                    <hr class="mb-4">
                    <div class="col-md-12 mb-12">
                        <label for="txtDr">Vendedor</label>
                        <?php
                        if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
                            ?>
                            <div class="col-md-12 mb-12">

                                <div class="input-group">

                                    <input type="text" class="form-control" id="txtDr" name="txtDr" value="<?= $dr; ?>" placeholder="Username" required="">
                                    <div class="invalid-feedback" style="width: 100%;">
                                        Your username is required.
                                    </div>
                                </div>
                            </div>

                            <?php
                        } else {
                            ?>
                            <select class="custom-select d-block w-100" id="txtDr" name="txtDr" required="">
                                <option value="Funcionário Lucas Gabriel"> Lucas Gabriel</option>
                                <?php
                                $cont = 0;

                                if ($listaUsuariosBusca != null) {

                                    foreach ($listaUsuariosBusca as $user) {
                                        ?>
                                        <option value="<?= $user->getNome(); ?>"> <?= $user->getNome(); ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <?php
                        }
                        ?>
                        <hr class="mb-4">
                        <input type="submit" name="btnSubmit" id="btnSubmit" value="Cadastrar"  class="btn btn-primary btn-lg btn-block" />

                        <?php if ($erros != null) { ?>
                            <hr class="mb-4">
                            <div class='alert alert-danger' role='alert'>
                                <ul id="ulErros" style="list-style: none;">
                                    <?php
                                    foreach ($erros as $e) {
                                        ?>
                                        <li><?= $e; ?></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div> 


            
            </div>




        </div>
    </div>

<script>
    $("#frmCadastro").submit(function (event) {
        if (!Validar()) {
            event.preventDefault();
        }
    });



    function Validar() {
        var erros = 0;

        var ulErros = document.getElementById("ulErros");
        ulErros.innerHTML = "";
        ulErros.style.color = "red";
        ulErros.style.listStyle = "none";

        if ($("#txtNome").val().length < 5) {
            var li = document.createElement("li");
            li.innerText = "- Nome inválido (min. 5 caracteres)";
            ulErros.appendChild(li);
            erros++;
        }

        if (erros == 0) {
            return true;
        } else {
            return false;
        }
    }

</script>