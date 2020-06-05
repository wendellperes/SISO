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

if (filter_input(INPUT_POST, "btnApagar", FILTER_SANITIZE_STRING)) {
    $cod = filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT);
    if ($usuarioController->Deletar2($cod)) {
        header('Location: painel.php?');
    } else {
        $resultado = "Houve um erro ao cadastrar";
    }
}


if (filter_input(INPUT_POST, "btnBuscar", FILTER_SANITIZE_STRING)) {
    
} else {
    $termo = "";
    $tipo = 1;
    $status = 1;

    $listaUsuariosBusca = $usuarioController->RetornarUsuarios($termo, $tipo, $status);
}
?>

<div class="my-1 p-3 bg-white rounded box-shadow">
    <h6 class="border-bottom border-gray pb-2 mb-0">Lista de Usuários</h6>
<?php
$cont = 0;
if ($listaUsuariosBusca != null) {

    foreach ($listaUsuariosBusca as $user) {
        ?>

            <div class = "media text-muted pt-3">
                <a href="painel.php?pagina=usuario&cod=<?= $user->getCod(); ?>" style="color: #000; text-decoration:none; ">
                    <span style="position: relative; left: -35px; top: 3px; color: #fff;"><?= $user->getCod(); ?></span> 

                </a>
                <p class = "media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <a href="painel.php?pagina=usuario&cod=<?= $user->getCod(); ?>" style="color: #000;">
                        <strong class = "d-block text-gray-dark">@ <?= $user->getNome(); ?>  -  <?= $user->getCelular(); ?> </strong>
                    </a>
                <form name="form_cadastrarmovimento" method="post" action="" style="text-align:center;"  >
                    <input  type="hidden" value="<?= $user->getCod(); ?>" id="txtCod" name="txtCod" />
                    <input  type="submit" value="Excluir" class="btn btn-outline-danger btn-lg" name="btnApagar" />
                </form>
                </p>

            </div>
        <?php
    }
}
?>

</div>
