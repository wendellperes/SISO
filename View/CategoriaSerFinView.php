<?php
require_once ("Controller/CategoriaSerFinController.php");
require_once ("Model/CategoriaSerFin.php");


$categoriaserfinController = new CategoriaSerFinController();


$resultado = '';

$nome = "";

$erros = [];

$ListaCategoriass = [];



if (filter_input(INPUT_POST, "btnCadastrar", FILTER_SANITIZE_STRING)) {

    $nome = (filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING));
    $erros = Validar();


    if (empty($erros)) {
        $catserfin = new CategoriaSerFin();
        $catserfin->setNome($nome);


        if (!filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
            //Cadastrar
            if ($categoriaserfinController->Cadastrar($catserfin)) {
                $cod = 0;
                $nome = "";
                $resultado = " <div class='alert alert-success' role='alert'><span>Categoria cadastrada com sucesso! </span> </div>";
            } else {
                $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um herro ao cadastrar nova categoria!</span> </div>";
            }
        } else {
            //Editar
            $catserfin->setId(filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT));

            if ($categoriaserfinController->Alterar($catserfin)) {
                $resultado = " <div class='alert alert-success' role='alert'><span>Dados da categoria alterado com sucesso!<a href='painel.php?pagina=catserfin'> Clique aqui para voltar para serviços. </a></span> </div>";
            } else {
                $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um erro ao alterar dados da categoria!</span> </div>";
            }
        }
    }
}

if (filter_input(INPUT_POST, "btnApagar", FILTER_SANITIZE_STRING)) {
    if ($servicoController->Deletar(filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT))) {
        $cod = 0;
        $nome = "";
        $descricao = "";
        $valor = "";
        $resultado = " <div class='alert alert-success' role='alert'><span>Serviço excluído com sucesso! </span> </div>";

        header("location: painel.php?pagina=servico");
    } else {
        $resultado = " <div class='alert alert-danger' role='alert'><span>Houve um herro ao excluir o Serviço!</span> </div>";
    }
}

function Validar() {
    $listaErros = [];

    $categoriaserfinController = new CategoriaSerFinController();
    if (strlen(filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING)) < 1) {
        $listaErros[] = "- Nome inválido.";
    }

    return $listaErros;
}

if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {

    $cod = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);

    $ListaCategoriass = $categoriaserfinController->RetornarCategorias2($cod);
    if ($ListaCategoriass != null) {
        foreach ($ListaCategoriass as $user0) {

            $cod_catserfin = $user0->getId();
            $nome2 = $user0->getNome();
            
        }
    }
} else {

      $ListaCategorias = $categoriaserfinController->RetornarCategorias();
   
}
?>
<style>
    #eusouomestre:hover{
        color:#fff;
    }
</style>

<link href="../Interface/Bootstrap/responsividade.css" rel="stylesheet" type="text/css"/>
<?= $resultado; ?>

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
<?php
if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
    ?>
    <form name="form_cadastrarmovimento" method="post" action="" style="text-align:left;"  >
        <div class="row">
            <div class="container">
                <div class="jumbotron mt-3">

                    <h1 style="color:#blue;">Editar Categoria de Serviços e Financeiro</h1>
                    <p class="lead">Editar Nome.<span style="color: red;"> Atenção para não alterar incorretamente ao dados</span></p>

                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group label-floating">
                    <label for="txtNome" class="control-label">Nome</label>
                    <input  type="text" class="form-control" id="txtNome" name="txtNome" value="<?= $nome2; ?>">
                </div>
            </div>
            
            <div class="col-sm-12" style="text-align:center;">


            </div>
        </div>
        <input type="hidden" id="txtCodServico" name="txtCodServico" value="<?= $cod_catserfin; ?>"
               <div class="modal-footer">
            <input  type="submit" value="Alterar Dados do Serviço" class="btn btn-outline-dark btn-lg" name="btnCadastrar" />
        </div>
    </form>

    <?php
} else {
    ?>

    <div class="container">
        <div class="jumbotron mt-3">

            <h1 style="color:#blue;">Categorias</h1>
            <p class="lead">Categorias Cadastrados</p>

            <a class="btn btn-outline-dark btn-lg" id="eusouomestre"  role="button" data-toggle="modal" data-target="#exampleModal3">Adicionar nova categoria</a>
        </div>
    </div>

    <div class="my-1 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Categorias</h6>
        <?php
        if ($ListaCategorias != null) {
            foreach ($ListaCategorias as $user) {
                ?>

                <div class = "media text-muted pt-3">
                    <a href="painel.php?pagina=catserfin&cod=<?= $user->getId(); ?>" style="color: #000; text-decoration:none; ">
                        <img data-src = "holder.js/32x32?theme=thumb&amp;bg=007bff&amp;fg=007bff&amp;size=1" alt = "32x32" class = "mr-2 rounded" style = "width: 32px; height: 32px;" src = "data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2232%22%20height%3D%2232%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2032%2032%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_162f824d082%20text%20%7B%20fill%3A%23007bff%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A2pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_162f824d082%22%3E%3Crect%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22%23007bff%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2211.703125%22%20y%3D%2216.9984375%22%3E32x32%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered = "true">
                        <span style="position: relative; left: -35px; top: 3px; color: #fff;"><?= $user->getId(); ?></span> 

                    </a>
                    <p class = "media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <a href="painel.php?pagina=catserfin&cod=<?= $user->getId(); ?>" style="color: #000;">
                            <strong class = "d-block text-gray-dark">@ <?= $user->getNome(); ?> </strong>
                        </a>
                        
                    </p>
                </div>
                <?php
            }
        } else {
            echo "Não há nenhum Serviço Cadastrado";
        }
        ?>
        <small class = "d-block text-right mt-3">
            <a href = "#">Ver Todos</a>
        </small>
    </div>﻿

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Adicionar Serviço</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="form_cadastrarmovimento" method="post" action="" style="text-align:left;"  >
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-group label-floating">
                                    <label for="txtNome" class="control-label">Nome</label>
                                    <input  type="text" class="form-control" id="txtNome" name="txtNome" value="<?= $nome; ?>">
                                </div>
                            </div>
                            
                            <div class="col-sm-12" style="text-align:center;">


                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-lg" data-dismiss="modal">Close</button>
                            <input  type="submit" value="Cadastrar Serviço" class="btn btn-outline-dark btn-lg" name="btnCadastrar" />

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

