<?php
$erros = [];

require_once("../Model/Usuario.php");

require_once("../Controller/UsuarioController.php");

require_once("../Util/UploadFile.php");

$usuarioController = new UsuarioController();

$cod = 0;
$nome = "";
$usuario = "";
$rg = "";
$cpf = "";
$email = "";
$foto = "";
$permissao = 0;
$rua = "";
$bairro = "";
$numero = "";
$celular = "";
$senha = "";

$resultado = "";

$listaUsuariosBusca = [];


if (filter_input(INPUT_POST, "btnSubmit", FILTER_SANITIZE_STRING)) {

    $erros = Validar();

    $nome = filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING);
    $usuario2 = filter_input(INPUT_POST, "txtUsuario", FILTER_SANITIZE_STRING);
    $rg = filter_input(INPUT_POST, "txtRg", FILTER_SANITIZE_STRING);
    $cpf = filter_input(INPUT_POST, "txtCpf", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_STRING);
    $foto = filter_input(INPUT_POST, "txtFoto", FILTER_SANITIZE_STRING);
    $permissao = filter_input(INPUT_POST, "txtPermissao", FILTER_SANITIZE_NUMBER_INT);
    $rua = filter_input(INPUT_POST, "txtRua", FILTER_SANITIZE_STRING);
    $bairro = filter_input(INPUT_POST, "txtBairro", FILTER_SANITIZE_STRING);
    $numero = filter_input(INPUT_POST, "txtNumero", FILTER_SANITIZE_STRING);
    $celular = filter_input(INPUT_POST, "txtCelular", FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, "txtSenha", FILTER_SANITIZE_STRING);
    $senha = md5($senha);

    if (empty($erros)) {

        $usuario = new Usuario();



        $usuario->setNome($nome);
        $usuario->setUsuario($usuario2);
        $usuario->setRg($rg);
        $usuario->setCpf($cpf);
        $usuario->setEmail($email);
        $usuario->setPermissao($permissao);
        $usuario->setRua($rua);
        $usuario->setBairro($bairro);
        $usuario->setNumero($numero);
        $usuario->setCelular($celular);
        $usuario->setSenha($senha);
        
        
        if (!filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
            //Cadastrar
            $upload = new Upload();
            $nomeImagem = $upload->LoadFile("../Interface/img/Usuarios/", "img", $_FILES["flImagem"]);
            $usuario->setFoto($nomeImagem);
            if ($nomeImagem != "" && $nomeImagem != "invalid") {
                if ($usuarioController->Cadastrar($usuario)) {

                    $cod = 0;
                    $nome = "";
                    $usuario = "";
                    $rg = "";
                    $cpf = "";
                    $email = "";
                    $foto = "";
                    $permissao = 0;
                    $rua = "";
                    $bairro = "";
                    $numero = "";
                    $celular = "";
                    $senha = "";

                    $resultado = " <div class='alert alert-success' role='alert'><span>Usuario cadastrado com sucesso!</span> </div>";
                } else {
                    $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um erro ao cadastrar Usuario!</span> </div>";
                }
            } else if ($nomeImagem == "invalid") {
                $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Formato de imagem inválido.</div>";
            } else {
                $resultado = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar carregar a imagem.</div>";
            }
        } else {
            //Editar
            $usuario->setCod(filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT));

            if ($usuarioController->Alterar($usuario)) {
                $resultado = " <div class='alert alert-success' role='alert'><span>Dados do usuario alterado com sucesso!</span> </div>";
            } else {
                $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um erro ao alterar dados do usuario!</span> </div>";
            }
        }
    }
}

function Validar() {
    $listaErros = [];

    $usuarioController = new UsuarioController();


    if (strlen(filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING)) < 1) {
        $listaErros[] = "- Nome inválido.";
    }

    if (strlen(filter_input(INPUT_POST, "txtUsuario", FILTER_SANITIZE_STRING)) < 1) {
        $listaErros[] = "- Usuario inválido.";
    }



    return $listaErros;
}

if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
    $termo = "";
    $status = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
    $tipo = 2;
    $listaUsuariosBusca = $usuarioController->RetornarUsuarios($termo, $tipo, $status);
    //var_dump($listaPacientesBusca);
}

if ($listaUsuariosBusca != null) {
    foreach ($listaUsuariosBusca as $user) {
        $cod = $user->getCod();
        $nome = $user->getNome();
        $usuario = $user->getUsuario();
        $rg = $user->getRg();
        $cpf = $user->getCpf();
        $email = $user->getEmail();
        $foto = $user->getFoto();
        $permissao = $user->getPermissao();
        $rua = $user->getRua();
        $bairro = $user->getBairro();
        $numero = $user->getNumero();
        $celular = $user->getCelular();
        $senha = $user->getSenha();
    }
}
?>
<div class="container">
    <div class="row">   
        <div class="col-md-12 order-md-1">

             <form name="form_cadastrarmovimento" method="post" action="" style="text-align:left;" novalidate enctype="multipart/form-data">
                       <?php
                echo $resultado;
                ?>


                <hr class="mb-4">  

                <h4 class="mb-3">Dados Pessoais</h4>
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="txtNome">Nome Completo:</label>
                        <input type="text" class="form-control" id="txtNome" name="txtNome" placeholder="" value="<?= $nome; ?>" required="">
                        <div class="invalid-feedback">
                            Nome requerido.
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="txtUsuario">Usuario:<small style="color:#ccc;"> Ex: @Elanddji</small></label>
                        <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="" value="<?= $usuario; ?>" required="">
                        <div class="invalid-feedback">
                            Usuario requerida.
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
                    <div class="col-md-6 mb-3">
                        <label for="txtEmail">Email:</label>
                        <input type="text" class="form-control" id="txtEmail" name="txtEmail" placeholder="" value="<?= $email; ?>" required="">
                        <div class="invalid-feedback">
                            Email requerido.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="txtPermissao">Permissão</label>
                        <select class="custom-select d-block w-100" id="txtPermissao" name="txtPermissao" required="">

                            <option value="1" <?= ($permissao == "1" ? "selected='selected'" : "") ?>>Adm</option>
                            <option value="2" <?= ($permissao == "2" ? "selected='selected'" : "") ?>>Funcionário</option>

                        </select>
                        <div class="invalid-feedback">
                            Please select a valid country.
                        </div>
                    </div>
                </div>
                <hr class="mb-4">    
                <h4 class="mb-3">Endereço</h4>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="txtRua">Rua:</label>
                        <input type="text" class="form-control" id="txtRua" name="txtRua" placeholder="" value="<?= $rua; ?>" required="">
                        <div class="invalid-feedback">
                            Rua requerida.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="txtBairro">Bairro:</label>
                        <input type="text" class="form-control" id="txtBairro" name="txtBairro" placeholder="" value="<?= $bairro; ?> " required="">
                        <div class="invalid-feedback">
                            Complemento Requerido.
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
                        <label for="txtCelular">Celular:</label>
                        <input type="text" class="form-control" id="txtCelular"  name="txtCelular" placeholder="" value="<?= $celular; ?> " required="">
                        <div class="invalid-feedback">
                            Nº requerido.
                        </div>
                    </div>


                    <div class="col-md-6 mb-3">
                        <label for="txtSenha">Senha:</label>
                        <input type="text" class="form-control" id="txtSenha"  name="txtSenha" placeholder="" value="<?= $senha; ?> " required="">
                        <div class="invalid-feedback">
                            Nº requerido.
                        </div>
                    </div>
                    
                         <div class="col-sm-12">
                                <div class="form-group label-floating">
                                    <label for="flImagem" class="control-label"></label>            
                                    <input type="file" id="flImagem" name="flImagem"  accept="image/*" />
                                </div>
                            </div>
            

                </div>



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
                <hr class="mb-4">

                <input type="submit" name="btnSubmit" id="btnSubmit" value="Cadastrar"  class="btn btn-primary btn-lg btn-block" />
            </form>
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