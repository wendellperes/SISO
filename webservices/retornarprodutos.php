<?php
 Error_reporting (0);
session_start();
// Incluir aquivo de conex�o
include("conn.php");

$valor = $_GET['valor'];
$tipo = $_GET['tipo'];
$param = $_GET['param'];

$dia = 0;
$mes = 0;
$ano = 0;
$notafiscal = "";
$cod_funcionario = 0;
$codentrada = 0;
$cod_func = 0;

$cod_saida = 0;
$cod_destinatarioS = 0;
$cod_funcionarioS = 0;
$diaS = 0;
$mesS = 0;
$anoS = 0;
$cod_orgaoS = 0;
$textoStatusS = 0;
$textostatus = "";
$cod_produtoL = 0;
$cod_listaentradas = 0;


$cod_solicitacoes = 0;
$cod_funcionarioSo = 0;
$qtdSo = 0;
$diaSo = 0;
$mesSo = 0;
$anoSo = 0;
$cod_orgaoSo = 0;
$statusSo = 0;


$textoStatusSo = "";
$variavelStatusSolicitacao = "";
$cod_funcionarioSo = 0;

$statusp=0;
$statustexto="";

$cod_func = $_SESSION['codF'];
$cod_org = $_SESSION['cod_orgaoF'];

switch ($tipo) {
    case 1:
        $sql = mysqli_query($conn, "SELECT * FROM produtos WHERE descricao LIKE '%" . $valor . "%' ORDER BY cod DESC LIMIT 1");

// Exibe todos os valores encontrados
        while ($produtos = mysqli_fetch_object($sql)) {
            $codproduto = $produtos->cod;
            $apresentacao = $produtos->apresentacao;
            $qtdat = $produtos->qtd;
            $tipo = $produtos->tipo;
            $statusp = $produtos->status;
            $fornecedor = $produtos->fornecedor;
            $cod_orgao = $produtos->cod_orgao;
            $est_mim = $produtos->est_mim;
            $est_max = $produtos->est_max;
            $cod_barra = $produtos->cod_barra;
            $descricao = $produtos->descricao;
            $img = $produtos->img;
            $valorunt = number_format($produtos->valor, 2, ',', '.');
            $categoria = $produtos->categoria;

            if ($statusp == 1) {
                $statustexto = "<small style='color:blue'>Estoque Normal</small>";
            } else if ($statusp == 2) {
                $statustexto = "<small style='color:red'>Estoque Critico</small>";
            }
            


            $sql11 = mysqli_query($conn, "SELECT * FROM fornecedores WHERE cod = $fornecedor ORDER BY cod DESC LIMIT 1");
            // Exibe todos os valores encontrados
            while ($fpr = mysqli_fetch_object($sql11)) {
                $fornecedor = $fpr->descricao;
            }

            $sql2 = mysqli_query($conn, "SELECT * FROM categoria_produto WHERE cod=" . $categoria . " LIMIT 1");
            while ($categorias = mysqli_fetch_object($sql2)) {
                $nomecategoria = $categorias->nome;
            }
            if ($img == null) {
                $img = "LOGOSEMSA.png";
            }

            $sql2 = mysqli_query($conn, "SELECT * FROM lista_entradas WHERE cod_produto = $codproduto ORDER BY cod DESC LIMIT 1");
            while ($entradas = mysqli_fetch_object($sql2)) {
                $codentrada = $entradas->cod_entrada;
                $lote = $entradas->lote;
                $mes_validade = $entradas->mes_validade;
                $ano_validade = $entradas->ano_validade;
                $qtd = $entradas->qtd;
                $valor_total = number_format($entradas->valor_total, 2, ',', '.');
            }
            $sqlnota = mysqli_query($conn, "SELECT * FROM entradas WHERE cod = $codentrada ORDER BY cod DESC LIMIT 1");
            while ($entradasNota = mysqli_fetch_object($sqlnota)) {
                $nota_fiscal = $entradasNota->n_notafiscal;
            }

            $sql33 = mysqli_query($conn, "SELECT * FROM lista_saidas WHERE cod_produto = $codproduto ORDER BY cod DESC LIMIT 1");
            while ($lista_saidas = mysqli_fetch_object($sql33)) {
                $cod_saida = $lista_saidas->cod_saida;
                $cod_produtoL = $lista_saidas->cod_produto;
                $cod_listaentradas = $lista_saidas->cod_listaentradas;
            }

            $sql34 = mysqli_query($conn, "SELECT * FROM saidas WHERE cod = $cod_saida ORDER BY cod DESC LIMIT 1");
            while ($saidas = mysqli_fetch_object($sql34)) {
                $cod_saida = $saidas->cod;
                $cod_destinatarioS = $saidas->cod_destinatario;
                $cod_funcionarioS = $saidas->cod_funcionario;
                $diaS = $saidas->dia;
                $mesS = $saidas->mes;
                $anoS = $saidas->ano;
                $cod_orgaoS = $saidas->cod_orgao;
                $statusS = $saidas->status;

                if ($statusS == 1) {
                    $textoStatusS = "Aberto";
                } else if ($statusS == 2) {
                    $textoStatusS = "Concluído";
                }

                $sql4 = mysqli_query($conn, "SELECT * FROM funcionarios WHERE cod = $cod_funcionarioS ORDER BY cod DESC LIMIT 1");

                // Exibe todos os valores encontrados
                while ($func = mysqli_fetch_object($sql4)) {
                    $cod_funcionarioS = $func->nome;
                }
                $sql5 = mysqli_query($conn, "SELECT * FROM orgaos WHERE cod = $cod_destinatarioS ORDER BY cod DESC LIMIT 1");

                // Exibe todos os valores encontrados
                while ($desti = mysqli_fetch_object($sql5)) {
                    $cod_destinatarioS = $desti->nome;
                }
            }

            $sql35 = mysqli_query($conn, "SELECT * FROM solicitacoes WHERE cod_produto = $codproduto ORDER BY cod DESC LIMIT 1");
            while ($solicitacoes = mysqli_fetch_object($sql35)) {
                $cod_solicitacoes = $solicitacoes->cod;
                $cod_funcionarioSo = $solicitacoes->cod_funcionario;
                $qtdSo = $solicitacoes->qtd;
                $diaSo = $solicitacoes->dia;
                $mesSo = $solicitacoes->mes;
                $anoSo = $solicitacoes->ano;
                $cod_orgaoSo = $solicitacoes->cod_orgao;
                $statusSo = $solicitacoes->status;

                if ($statusSo == 1) {
                    $variavelStatusSolicitacao = ""
                            . "            <div  id='headingTwo339$codproduto' style='width:100%; text-align:center;'>
                                                <a style='' class='btn btn-outline-warning badge-pill' data-toggle='collapse' data-target='#collapseTwo339$codproduto' aria-expanded='false' aria-controls='collapseTwo339$codproduto'>
                                                    a Receber   
                                                </a>
                                            </div>
                                            <div id='collapseTwo339$codproduto' class='collapse card' style='margin: 5px;' aria-labelledby='headingTwo339$codproduto' data-parent='#accordion'>
                                                <form method='post' name='frmCadastro' id='frmCadastro' novalidate enctype='multipart/form-data'>
                                                    <input type='hidden' name='txtCod_soli' id='txtCod_soli' value='$cod_solicitacoes' />
                                                    <input type='hidden' name='txtCod_orgao' id='txtCod_orgao' value='" . $_SESSION['cod_orgaoF'] . "' />
                                                    <input type='hidden' name='txtCodproduto' id='txtCodproduto' value='$codproduto' />
                                                    <input type='hidden' name='txtCodFuncionario' id='txtCodFuncionario' value='" . $_SESSION['codF'] . "' />
                                                        
                                                    <input type='text' class='form-control' style='width:100%;' id='txtConferidor1' name='txtConferidor1' placeholder='Digite o nome do conferidor 1' value='' required='' autofocus=''>
                                                    <input type='text' class='form-control' style='width:100%;' id='txtConferidor2' name='txtConferidor2' placeholder='Digite o nome do conferidor 2' value='' required='' autofocus=''>
                                                    <input type='text' class='form-control' style='width:100%;' id='txtConferidor3' name='txtConferidor3' placeholder='Digite o nome do conferidor 3' value='' required='' autofocus=''>
                                
                                                    <input type='text' class='form-control' style='width:100%;' id='txtNotafiscal' name='txtNotafiscal' placeholder='Digite Nota Fiscal' value='' required='' autofocus=''>
                                                    <input style='width:100%; padding:3px;' class='btn btn-outline-success btn-lg' type='submit' name='btnCadastrarEntradaSoli' id='btnCadastrarEntradaSoli' value='Nova Entrada'/>
                                                </form>                                  

                                            </div>";
                } else if ($statusSo == 2) {
                    $variavelStatusSolicitacao = "
                                                <a class='btn btn-outline-success badge-pill'>
                                                    Recebido   
                                                </a>
                                           ";
                }

                $sql466 = mysqli_query($conn, "SELECT * FROM funcionarios WHERE cod = $cod_funcionarioSo ORDER BY cod DESC LIMIT 1");

                // Exibe todos os valores encontrados
                while ($func = mysqli_fetch_object($sql466)) {
                    $cod_funcionarioSo = $func->nome;
                }
            }

            $sqlOr = mysqli_query($conn, "SELECT * FROM orgaos ORDER BY cod ASC");
            $optionOrgaos = "";
            // Exibe todos os valores encontrados
            while ($orgaos = mysqli_fetch_object($sqlOr)) {
                $optionOrgaos = $optionOrgaos . "<option value='$orgaos->cod'>$orgaos->nome</option>";
            }
            $cod_org_prod = $_SESSION['cod_orgaoF'] ;


            echo "
            <div class=\"card\" style=\"margin:15px;\">
                <div class=\"card-body\">
                    <div class=\"row\">
                            <div class=\"col-4 col-md-4\">
                                <div style=\"margin-left:25px;\">
                                <small><b>Descricao</b>: $descricao</small>
                                </br>
                                <small><b>Valor Unt.</b>: R$ $valorunt</small>
                                </br>
                                <small><b>Qtd.</b>: $qtdat</small>
                                </br>
                                <small><b>Est. Min.</b>: $est_mim</small>
                                </br>
                                <small><b>Status.</b>: $statustexto</small>
                                </div>    
                            </div>
                            <div class='col-8 col-md-8' style='text-align:center;'>
                                <img src='../Interface/img/Produtos/$img' class='img-fluid' style='width: 30%;' />
                                    </br>
                                     <a style='' class='btn btn-outline-info badge-pill' data-toggle='collapse' data-target='#collapseTwo343$codproduto' aria-expanded='false' aria-controls='collapseTwo343$codproduto'>
                                        Entradas   
                                    </a>
                                     <a style='' class='btn btn-outline-info badge-pill' data-toggle='collapse' data-target='#collapseTwo344$codproduto' aria-expanded='false' aria-controls='collapseTwo344$codproduto'>
                                        Saídas   
                                    </a>
                                     <a style='' class='btn btn-outline-info badge-pill' data-toggle='collapse' data-target='#collapseTwo345$codproduto' aria-expanded='false' aria-controls='collapseTwo345$codproduto'>
                                        Solicitações   
                                    </a>
                                    <a style='' class='btn btn-outline-info badge-pill' data-toggle='collapse' data-target='#collapseTwo33$codproduto' aria-expanded='false' aria-controls='collapseTwo33$codproduto'>
                                        Editar   
                                    </a>
                               
                                    <div id='collapseTwo343$codproduto' class='collapse card' style='margin: 5px;' aria-labelledby='headingTwo343$codproduto' data-parent='#accordion'>
                                         <table class='table table-bordered table-light table-striped'>
                                            <thead>
                                            <tr>
                                                <th>Nota Fiscal</th>
                                                <th>Lote</th>
                                                <th>Validade</th>
                                                <th>Qtd</th>
                                                <th>Valor Total</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td><b><a class='btn btn-outline-info badge-pill' href='?pagina=entradas&cod=$codentrada'>$nota_fiscal</a></b></td>
                                                <td><b>$lote</b></td>
                                                <td><b>$mes_validade/$ano_validade</b></td>
                                                <td><b>$qtd</b></td>    
                                                <td><b>R$ $valor_total</b></td>
                                               
                                            </tr>
                                            <tr>
                                                    <td colspan='5'>
                                                     <form method='post' name='frmCadastro' id='frmCadastro' novalidate enctype='multipart/form-data'>
                                                    <input type='hidden' name='txtCod_orgao' id='txtCod_orgao' value='" . $_SESSION['cod_orgaoF'] . "' />
                                                    <input type='hidden' name='txtCodproduto' id='txtCodproduto' value='$codproduto' />
                                                    <input type='hidden' name='txtCodFuncionario' id='txtCodFuncionario' value='" . $_SESSION['codF'] . "' />
                                                    <input type='text' class='form-control' style='width:100%;' id='txtConferidor1' name='txtConferidor1' placeholder='Digite o nome do conferidor 1' value='' required='' autofocus=''>
                                                    <input type='text' class='form-control' style='width:100%;' id='txtConferidor2' name='txtConferidor2' placeholder='Digite o nome do conferidor 2' value='' required='' autofocus=''>
                                                    <input type='text' class='form-control' style='width:100%;' id='txtConferidor3' name='txtConferidor3' placeholder='Digite o nome do conferidor 3' value='' required='' autofocus=''>
                                                    
                                                    <input type='text' class='form-control' style='width:100%;' id='txtNotafiscal' name='txtNotafiscal' placeholder='Digite Nota Fiscal' value='' required='' autofocus=''>
                                                    <input style='width:100%; padding:3px;' class='btn btn-outline-success btn-lg' type='submit' name='btnCadastrarEntrada' id='btnCadastrarEntrada' value='Nova Entrada'/>
                                                    </form>                                                                                                       
                                                  </td>

                                            </tr>
                                         </table>
                                       
                                    </div>
                                    <div id='collapseTwo344$codproduto' class='collapse card' style='margin: 5px;' aria-labelledby='headingTwo344$codproduto' data-parent='#accordion'>
                                         <table class='table table-bordered table-light table-striped'>
                                            <thead>
                                            <tr>
                                                <th>Destinatário</th>
                                                <th>Funcionário</th>
                                                <th>Status</th>
                                                <th>Última Saída</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td><b>$cod_destinatarioS</b></td>
                                                <td><b>$cod_funcionarioS</b></td>
                                                <td><a class='btn btn-outline-info badge-pill' href='?pagina=saidas&cod=$cod_saida'> <b>$textoStatusS</b></a></td>
                                                <td><b>$diaS/$mesS/$anoS</b></td>
                                            </tr>
                                            <tr>
                                                    <td colspan='4'>
                                                        <form method='post' name='frmCadastro' id='frmCadastro' novalidate enctype='multipart/form-data'>
                                                        Destinátario
                                                        <select name='txtCod_destinatario' id='txtCod_destinatario' class='form-control' style='width:100%; margin-bottom:5px;'>
                                                            $optionOrgaos
                                                        </select>
                                                        <input type='hidden' name='txtCod_funcionario' id='txtCod_funcionario' value='$cod_func' />
                                                        <input type='hidden' name='txtCod_orgao' id='txtCod_orgao' value='$cod_org' />
                                                        <input style='width:100%; padding:3px;' class='btn btn-outline-warning btn-lg' type='submit' name='btnCadastrarSaida' id='btnCadastrarCancelarEntrada' value='Nova saída'/>
                                                        </form>
                                                    </td>
                                            </tr>
                                         </table>
                                    </div>
                                     <div id='collapseTwo345$codproduto' class='collapse card' style='margin: 5px;' aria-labelledby='headingTwo345$codproduto' data-parent='#accordion'>
                                         <table class='table table-bordered table-light table-striped'>
                                            <thead>
                                            <tr>
                                                <th>Qtd</th>
                                                <th>Funcionário</th>
                                                <th>Status</th>
                                                <th>Última Solicitação</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td><b>$qtdSo</b></td>
                                                <td><b>$cod_funcionarioSo</b></td>
                                                <td>
                                                    $variavelStatusSolicitacao
                                                </td>
                                                <td><b>$diaSo/$mesSo/$anoSo</b></td>
                                            </tr>
                                            <tr>
                                                    <td colspan='4'>
                                                        <form method='post' name='frmCadastro' id='frmCadastro' novalidate enctype='multipart/form-data'>
                                                            <b>Qtd Solicitada:</b>
                                                            <input type='text' name='txtQtdSoli' id='txtQtdSoli' value='' class='form-control' />
                                                            <input type='hidden' name='txtCod_prod' id='txtCod_prod' value='$codproduto' />
                                                            <input style='width:100%; padding:3px;' class='btn btn-outline-primary btn-lg' style='' type='submit' name='btnCadastrarSolicitarEs' id='btnCadastrarSolicitarEs' value='Solicitar'/>
                                                            </form> 
                                                        </td>
                                            </tr>
                                         </table>
            
                                    </div>
                                    <div id='collapseTwo33$codproduto' class='collapse card' style='margin: 5px;' aria-labelledby='headingTwo33$codproduto' data-parent='#accordion'>
                                         <form style='text-align:left;' method='post' name='frmCadastro' id='frmCadastro' novalidate enctype='multipart/form-data'>
                                            <div class='row'>
                                                <div class='col-12 col-md-12'>
                                                    <label for='txtDescricao'>Descrição:</label>
                                                    <input type='text' class='form-control' id='txtDescricao' name='txtDescricao' placeholder='' value='$descricao' required=''>
                                                </div> 
                                                <div class='col-6 col-md-6'>
                                                    <label for='txtValor'>Valor Unt.:</label>
                                                    <input type='text' class='form-control' id='txtValor' name='txtValor' placeholder='' value='$valorunt' required=''>
                                                </div>
                                                <div class='col-6 col-md-6'>
                                                    <label for='txtEst_mim'>Est. Mim:</label>
                                                    <input type='text' class='form-control' id='txtEst_mim' name='txtEst_mim' placeholder='' value='$est_mim' required=''>
                                                </div>
                                                <input type='hidden' class='form-control' id='txtEst_max' name='txtEst_max' placeholder='' value='0' required='' >
                                                <input id='txtCod' name='txtCod' type='hidden' value='$codproduto'/>
                                                <input id='txtCod_orgao' name='txtCod_orgao' type='hidden' value='$cod_org_prod'/>
                                                <input id='txtCategoria' name='txtCategoria' type='hidden' value='1'/>
                                                <input id='txtFornecedor' name='txtFornecedor' type='hidden' value='0'/>    
                                               
                                            </div>
                                                 <input style='width:100%;' class='btn btn-outline-warning btn-lg' type='submit' name='btnAlterarProduto' id='btnAlterarProduto' value='Alterar Produto'/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>         
                ";
        }
        //header("Content-Type: text/html; charset=ISO-8859-1", true);
        break;

    case 2:
        $sql = mysqli_query($conn, "SELECT * FROM produtos WHERE descricao LIKE '%" . $valor . "%'  ORDER BY cod DESC");

// Exibe todos os valores encontrados
        while ($produtos = mysqli_fetch_object($sql)) {
            $codproduto = $produtos->cod;
            $apresentacao = $produtos->apresentacao;
            $qtd = $produtos->qtd;
            $tipo = $produtos->tipo;
            $status = $produtos->status;
            $fornecedor = $produtos->fornecedor;
            $cod_orgaoF = $produtos->cod_orgao;
            $est_mim = $produtos->est_mim;
            $est_max = $produtos->est_max;
            $cod_barra = $produtos->cod_barra;
            $descricao = $produtos->descricao;
            $img = $produtos->img;
            $valorunt = number_format($produtos->valor, 2, ',', '.');
            $categoria = $produtos->categoria;
            $sql2 = mysqli_query($conn, "SELECT * FROM categoria_produto WHERE cod=" . $categoria . " LIMIT 1");
            while ($categorias = mysqli_fetch_object($sql2)) {
                $nomecategoria = $categorias->nome;
            }
            if ($img == null) {
                $img = "LOGOSEMSA.png";
            }


            echo "
                        <div class='card' style='margin:15px;'>
                <div class='card-body'>
                    <div class='row'>
                        
                        <div class='col-12 col-md-12'>
                            <small><b>Descrição</b>: $descricao</small>
                            </br>
                            <small><b>Qtd</b>: $qtd</small>
                            </br>
                            <small><b>Est. Min.</b>: $est_mim</small>
                            </br>
                                <div  id='headingTwo33$codproduto' style='width:100%; text-align:left;'>
                                    <a style='' class='btn btn-outline-info badge-pill' data-toggle='collapse' data-target='#collapseTwo33$codproduto' aria-expanded='false' aria-controls='collapseTwo33$codproduto'>
                                        Add   
                                    </a>
                               </div>
                               <div id='collapseTwo33$codproduto' class='collapse card' style='margin: 5px;' aria-labelledby='headingTwo33$codproduto' data-parent='#accordion'>
                                    <form method='post' name='frmCadastro' id='frmCadastro' novalidate enctype='multipart/form-data'>
                                                     <input type='hidden' name='txtCod_orgao' id='txtCod_orgao' value='$cod_orgaoF' />
                                                     <input type='hidden' name='txtCodproduto' id='txtCodproduto' value='$codproduto' />
                                                     <input type='hidden' name='txtCodFuncionario' id='txtCodFuncionario' value='" . $_SESSION['codF'] . "' />
                                                    <input type='text' class='form-control' style='width:100%;' id='txtConferidor1' name='txtConferidor1' placeholder='Digite o nome do conferidor 1' value='' required='' autofocus=''>
                                                    <input type='text' class='form-control' style='width:100%;' id='txtConferidor2' name='txtConferidor2' placeholder='Digite o nome do conferidor 2' value='' required='' autofocus=''>
                                                    <input type='text' class='form-control' style='width:100%;' id='txtConferidor3' name='txtConferidor3' placeholder='Digite o nome do conferidor 3' value='' required='' autofocus=''>
                                                  
                                                    <label for='txtNotafiscal'>Nota Fiscal:</label>
                                                    <input type='text' class='form-control' style='width:100%;' id='txtNotafiscal' name='txtNotafiscal' placeholder='' value='' required='' autofocus=''>
                                               
                                                <input style='width:100%;' class='btn btn-outline-success btn-lg' type='submit' name='btnCadastrarEntrada' id='btnCadastrarEntrada' value='Cadastrar Entrada'/>
                                               
                                        </form>
                                </div>
                        </div>
                        </div>    
                    </div>
                </div>
            </div> ";
        }
        break;

    case 3:
        $sql = mysqli_query($conn, "SELECT * FROM produtos WHERE descricao LIKE '%" . $valor . "%'  ORDER BY cod DESC");

// Exibe todos os valores encontrados
        while ($produtos = mysqli_fetch_object($sql)) {
            $codproduto = $produtos->cod;
            $apresentacao = $produtos->apresentacao;
            $qtd = $produtos->qtd;
            $tipo = $produtos->tipo;
            $status = $produtos->status;
            $fornecedor = $produtos->fornecedor;
            $cod_orgaoF = $produtos->cod_orgao;
            $est_mim = $produtos->est_mim;
            $est_max = $produtos->est_max;
            $cod_barra = $produtos->cod_barra;
            $descricao = $produtos->descricao;
            $img = $produtos->img;
            $valorunt = number_format($produtos->valor, 2, ',', '.');
            $categoria = $produtos->categoria;
            $sql2 = mysqli_query($conn, "SELECT * FROM categoria_produto WHERE cod=" . $categoria . " LIMIT 1");
            while ($categorias = mysqli_fetch_object($sql2)) {
                $nomecategoria = $categorias->nome;
            }
            if ($img == null) {
                $img = "LOGOSEMSA.png";
            }

            echo "
            <div class='card' style='margin:15px;'>
                <div class='card-body'>
                    <div class='row'>
                        <div class='col-6 col-md-6' style='text-align:center;'>
                            <small style='color:blue;'>Descricao</b>:</small><b> $descricao</b>
                            </br>
                        </div>  
                        <div class='col-6 col-md-6' style='text-align:center;'>
                            <small style='color:blue;'>Qtd:</small><b> $qtd</b>
                            </br>
                            <small style='color:blue;'>Est. min.:</small><b> $est_mim</b>
                            
                        </div>
                        
                        <div class='col-12 col-md-12' style='text-align:center;'>
                        
                                <div  id='headingTwo33$codproduto'>
                                    <a style='' class='btn btn-outline-primary badge-pill' data-toggle='collapse' data-target='#collapseTwo33$codproduto' aria-expanded='false' aria-controls='collapseTwo33$codproduto'>
                                       Selecione o Lote   
                                    </a>
                                </div>
                                <div id='collapseTwo33$codproduto' class='collapse card' style='margin: 5px;' aria-labelledby='headingTwo33$codproduto' data-parent='#accordion'>
                        ";

            $sql4 = mysqli_query($conn, "SELECT * FROM lista_entradas WHERE cod_produto = $codproduto ORDER BY cod DESC");
            // Exibe todos os valores encontrados
            while ($listaentradas = mysqli_fetch_object($sql4)) {
                $cod_listaentrada = $listaentradas->cod;
                $lote = $listaentradas->lote;
                $mes_validade = $listaentradas->mes_validade;
                $ano_validade = $listaentradas->ano_validade;
                $qtd = $listaentradas->qtd;
                $qtdsaida = 0;
                $qtdatual = 0;
                $sql5 = mysqli_query($conn, "SELECT * FROM lista_saidas WHERE cod_listaentradas = $cod_listaentrada ORDER BY cod DESC");
                // Exibe todos os valores encontrados
                while ($listasaidas2 = mysqli_fetch_object($sql5)) {
                    $qtdsaida = $qtdsaida + $listasaidas2->qtd;
                }
                $qtdatual = $qtd - $qtdsaida;

                $cod_entrada_saida = $cod_listaentrada . '-' . $param;

                if ($qtdatual != 0) {
                    echo "<a href=\"javascript:func()\" onclick=\"buscarProdutos(4, " . $codproduto . ", '" . $cod_entrada_saida . "')\" style='margin:5px;' class=\"btn btn-outline-secondary btn-lg\">
                                         <small style='color:blue;'>Lote:</small> $lote </br> <small style='color:blue;'>Validade:</small> $mes_validade/$ano_validade </br><small style='color:blue;'>Qtd Entrada:</small> $qtd  <small style='color:blue;'>Qtd Atual:</small> $qtdatual 
                                       </a>
                                ";
                }
            }
            echo "
                                </div>
                       </div>
                    </div>
               </div>
            </div>
                   ";
        header("Content-Type: text/html; charset=ISO-8859-1", true);

            
                }
        

        break;

    case 4:
        $cod_entrada_saida = $_GET['valor'];
        $t = explode("-", $cod_entrada_saida);
        $cod_listaentrada = $t[0];
        $cod_saida = $t[1];
        $cod_produto = $_GET['param'];

        $sql = mysqli_query($conn, "SELECT * FROM produtos WHERE cod = $cod_produto ORDER BY cod DESC LIMIT 1");

// Exibe todos os valores encontrados
        while ($produtos = mysqli_fetch_object($sql)) {
            $codproduto = $produtos->cod;
            $apresentacao = $produtos->apresentacao;
            $qtd = $produtos->qtd;
            $tipo = $produtos->tipo;
            $status = $produtos->status;
            $fornecedor = $produtos->fornecedor;
            $cod_orgaoF = $produtos->cod_orgao;
            $est_mim = $produtos->est_mim;
            $est_max = $produtos->est_max;
            $cod_barra = $produtos->cod_barra;
            $descricao = $produtos->descricao;
            $img = $produtos->img;
            $valorunt = number_format($produtos->valor, 2, ',', '.');
            $categoria = $produtos->categoria;
            $sql2 = mysqli_query($conn, "SELECT * FROM categoria_produto WHERE cod=" . $categoria . " LIMIT 1");
            while ($categorias = mysqli_fetch_object($sql2)) {
                $nomecategoria = $categorias->nome;
            }
            if ($img == null) {
                $img = "LOGOSEMSA.png";
            }
        }


        $sql4 = mysqli_query($conn, "SELECT * FROM lista_entradas WHERE cod = $cod_listaentrada ORDER BY cod DESC");
// Exibe todos os valores encontrados
        while ($listaentradas = mysqli_fetch_object($sql4)) {
            $cod_listaentrada = $listaentradas->cod;
            $lote = $listaentradas->lote;
            $mes_validade = $listaentradas->mes_validade;
            $ano_validade = $listaentradas->ano_validade;
            $qtd = $listaentradas->qtd;
            $qtdsaida = 0;
            $qtdatual = 0;
            $sql5 = mysqli_query($conn, "SELECT * FROM lista_saidas WHERE cod_listaentradas = $cod_listaentrada ORDER BY cod DESC");
// Exibe todos os valores encontrados
            while ($listasaidas2 = mysqli_fetch_object($sql5)) {
                $qtdsaida = $qtdsaida + $listasaidas2->qtd;
            }
            $qtdatual = $qtd - $qtdsaida;

            $cod_entrada_saida = $cod_listaentrada . '-' . $param;

            if ($qtdatual != 0) {
                
            }
        }

        echo "<form method='post' name='frmCadastro2' id='frmCadastro2' novalidate enctype='multipart/form-data'>
                                                     <input type='hidden' name='txtQtdatual' id='txtQtdatual' value='$qtdatual' />
                                                     <input type='hidden' name='txtCod_saida' id='txtCod_saida' value='$cod_saida' />
                                                     <input type='hidden' name='txtCod_produto' id='txtCod_produto' value='$cod_produto' />
                                                     <input type='hidden' name='txtCod_listaentradas' id='txtCod_listaentradas' value='" . $cod_listaentrada . "' />
                                                        <div class='card' style='margin:15px;'>
                                                            <div class='card-body'>
                                                            <div class='row'>
                                                                    <div class='col-6 col-md-6' style='text-align:center;'>
                                                                            <label for='txtqtd_saida'>Qtd de Saida:</label>
                                                                            <input type='text' class='btn-outline-secondary btn-lg' style='width:100%;' id='txtqtd_saida' name='txtqtd_saida' placeholder='' value='' onkeyup='Validacao(2, this.value, $qtdatual)' autofocus=''>
                                                                    </div>
                                                                    <div class='col-6 col-md-6' style='text-align:center;' id='resultadoqtdvalor'>
                                                                        <label for='txtqtd_saida'>.</label>
                                                                        <input style='width:100%;' class='btn btn-outline-success btn-lg' type='submit' name='btnCadastrarSaidaL' id='btnCadastrarSaidaL' value='Add+'/>
                                                                    </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                </form>";
        echo "
            <div class='card' style='margin:15px;'>
                <div class='card-body'>
                    <div class='row'>
                        <div class='col-6 col-md-6' style='text-align:center;'>
                            <small style='color:blue;'>Descricao</b>:</small><b> $descricao</b>
                            </br>
                        </div>  
                        <div class='col-6 col-md-6' style='text-align:center;'>
                            <small style='color:blue;'>Qtd:</small><b> $qtd</b>
                            </br>
                            <small style='color:blue;'>Est. min.:</small><b> $est_mim</b>
                        </div>
                    </div>
                </div>
            </div>";
        echo "
            <div class='card' style='margin:15px;'>
                <div class='card-body'>
                    <div class='row'>
                        <div class='col-6 col-md-6' style='text-align:center;'>
                            <small style='color:blue;'>Lote</b>:</small><b> $lote</b>
                            </br>
                            <small style='color:blue;'>Validade:</small><b>$mes_validade/$ano_validade</b>
                            </br>
                                
                        </div>  
                        <div class='col-6 col-md-6' style='text-align:center;'>
                            <small style='color:blue;'>Qtd de Entrada:</small><b> $qtd</b>
                            </br>
                            <small style='color:blue;'>Qtd Atual.:</small><b> $qtdatual</b>                          
                        </div>
                    </div>
                </div>
            </div>";
        
        header("Content-Type: text/html; charset=ISO-8859-1", true);
        break;

    case 5:
        $sql = mysqli_query($conn, "SELECT * FROM produtos WHERE descricao LIKE '%" . $valor . "%'  ORDER BY cod DESC");

// Exibe todos os valores encontrados
        while ($produtos = mysqli_fetch_object($sql)) {
            $codproduto = $produtos->cod;
            $apresentacao = $produtos->apresentacao;
            $qtd = $produtos->qtd;
            $tipo = $produtos->tipo;
            $status = $produtos->status;
            $fornecedor = $produtos->fornecedor;
            $cod_orgaoF = $produtos->cod_orgao;
            $est_mim = $produtos->est_mim;
            $est_max = $produtos->est_max;
            $cod_barra = $produtos->cod_barra;
            $descricao = $produtos->descricao;
            $img = $produtos->img;
            $valorunt = number_format($produtos->valor, 2, ',', '.');
            $categoria = $produtos->categoria;
            $sql2 = mysqli_query($conn, "SELECT * FROM categoria_produto WHERE cod=" . $categoria . " LIMIT 1");
            while ($categorias = mysqli_fetch_object($sql2)) {
                $nomecategoria = $categorias->nome;
            }
            if ($img == null) {
                $img = "LOGOSEMSA.png";
            }


            echo "
                        <div class='card' style='margin:15px;'>
                <div class='card-body'>
                    <div class='row'>
                        
                        <div class='col-12 col-md-12'>
                            <small><b>Descricao</b>: $descricao</small>
                            </br>
                            <small><b>Categoria</b>:$nomecategoria</small>
                            </br>
                            <small><b>Valor Unt.</b>: R$ $valorunt</small>
                                <div  id='headingTwo33$codproduto' style='width:100%; text-align:left;'>
                                    <a style='' class='btn btn-outline-info badge-pill' data-toggle='collapse' data-target='#collapseTwo33$codproduto' aria-expanded='false' aria-controls='collapseTwo33$codproduto'>
                                        Solicitar   
                                    </a>
                               </div>
                               <div id='collapseTwo33$codproduto' class='collapse card' style='margin: 5px;' aria-labelledby='headingTwo33$codproduto' data-parent='#accordion'>
                                        <form method='post' name='frmCadastro' id='frmCadastro' novalidate enctype='multipart/form-data'>
                                        <input type='text' name='txtQtdSoli' id='txtQtdSoli' value='$est_max' class='form-control' />
                                        <input type='hidden' name='txtCod_prod' id='txtCod_prod' value='$codproduto' />
                                        <input style='width:100%;' class='btn btn-outline-success btn-lg' style='' type='submit' name='btnCadastrarSolicitarEs' id='btnCadastrarSolicitarEs' value='CONFIRMAR'/>
                                        </form>                                     
                                         
                                </div>
                        </div>
                        </div>    
                    </div>
                </div>
            </div> ";
        header("Content-Type: text/html; charset=ISO-8859-1", true);
        
            
            }
        
        break;

    case 6:
        $sql = mysqli_query($conn, "SELECT * FROM produtos WHERE descricao LIKE '%" . $valor . "%' ORDER BY cod DESC");

// Exibe todos os valores encontrados
        while ($produtos = mysqli_fetch_object($sql)) {
            $codproduto = $produtos->cod;
            $apresentacao = $produtos->apresentacao;
            $qtd = $produtos->qtd;
            $tipo = $produtos->tipo;
            $statusp = $produtos->status;
            $fornecedor = $produtos->fornecedor;
            $cod_orgao = $produtos->cod_orgao;
            $est_mim = $produtos->est_mim;
            $est_max = $produtos->est_max;
            $cod_barra = $produtos->cod_barra;
            $descricao = $produtos->descricao;
            $img = $produtos->img;
            $valorunt = number_format($produtos->valor, 2, ',', '.');
            $categoria = $produtos->categoria;

            if ($statusp == 1) {
                $statusp = "<small style='color:blue'>Estoque Normal</small>";
            } else if ($statusp == 2) {
                $statusp = "<small style='color:red'>Estoque Crítico</small>";
            }


            $sql11 = mysqli_query($conn, "SELECT * FROM fornecedores WHERE cod = $fornecedor ORDER BY cod DESC LIMIT 1");
            // Exibe todos os valores encontrados
            while ($fpr = mysqli_fetch_object($sql11)) {
                $fornecedor = $fpr->descricao;
            }

            $sql2 = mysqli_query($conn, "SELECT * FROM categoria_produto WHERE cod=" . $categoria . " LIMIT 1");
            while ($categorias = mysqli_fetch_object($sql2)) {
                $nomecategoria = $categorias->nome;
            }
            if ($img == null) {
                $img = "LOGOSEMSA.png";
            }
            $sql2 = mysqli_query($conn, "SELECT * FROM entradas WHERE cod_produto = $codproduto ORDER BY cod DESC LIMIT 1");
            while ($entradas = mysqli_fetch_object($sql2)) {
                $codentrada = $entradas->cod;
                $notafiscal = $entradas->n_notafiscal;
                $cod_funcionario = $entradas->cod_funcionario;
                $dia = $entradas->dia;
                $mes = $entradas->mes;
                $ano = $entradas->ano;
                $sql3 = mysqli_query($conn, "SELECT * FROM funcionarios WHERE cod = $cod_funcionario ORDER BY cod DESC LIMIT 1");

// Exibe todos os valores encontrados
                while ($func = mysqli_fetch_object($sql3)) {
                    $cod_funcionario = $func->nome;
                }
            }

            $sql33 = mysqli_query($conn, "SELECT * FROM lista_saidas WHERE cod_produto = $codproduto ORDER BY cod DESC LIMIT 1");
            while ($lista_saidas = mysqli_fetch_object($sql33)) {
                $cod_saida = $lista_saidas->cod_saida;
                $cod_produtoL = $lista_saidas->cod_produto;
                $cod_listaentradas = $lista_saidas->cod_listaentradas;
            }

            $sql34 = mysqli_query($conn, "SELECT * FROM saidas WHERE cod = $cod_saida ORDER BY cod DESC LIMIT 1");
            while ($saidas = mysqli_fetch_object($sql34)) {
                $cod_saida = $saidas->cod;
                $cod_destinatarioS = $saidas->cod_destinatario;
                $cod_funcionarioS = $saidas->cod_funcionario;
                $diaS = $saidas->dia;
                $mesS = $saidas->mes;
                $anoS = $saidas->ano;
                $cod_orgaoS = $saidas->cod_orgao;
                $statusS = $saidas->status;

                if ($statusS == 1) {
                    $textoStatusS = "Aberto";
                } else if ($statusS == 2) {
                    $textoStatusS = "Concluído";
                }

                $sql4 = mysqli_query($conn, "SELECT * FROM funcionarios WHERE cod = $cod_funcionarioS ORDER BY cod DESC LIMIT 1");

                // Exibe todos os valores encontrados
                while ($func = mysqli_fetch_object($sql4)) {
                    $cod_funcionarioS = $func->nome;
                }
                $sql5 = mysqli_query($conn, "SELECT * FROM orgaos WHERE cod = $cod_destinatarioS ORDER BY cod DESC LIMIT 1");

                // Exibe todos os valores encontrados
                while ($desti = mysqli_fetch_object($sql5)) {
                    $cod_destinatarioS = $desti->nome;
                }
            }

            $sql35 = mysqli_query($conn, "SELECT * FROM solicitacoes WHERE cod_produto = $codproduto ORDER BY cod DESC LIMIT 1");
            while ($solicitacoes = mysqli_fetch_object($sql35)) {
                $cod_solicitacoes = $solicitacoes->cod;
                $cod_funcionarioSo = $solicitacoes->cod_funcionario;
                $qtdSo = $solicitacoes->qtd;
                $diaSo = $solicitacoes->dia;
                $mesSo = $solicitacoes->mes;
                $anoSo = $solicitacoes->ano;
                $cod_orgaoSo = $solicitacoes->cod_orgao;
                $statusSo = $solicitacoes->status;

                if ($statusSo == 1) {
                    $variavelStatusSolicitacao = ""
                            . "            <div  id='headingTwo339$codproduto' style='width:100%; text-align:center;'>
                                                <a style='' class='btn btn-outline-warning badge-pill' data-toggle='collapse' data-target='#collapseTwo339$codproduto' aria-expanded='false' aria-controls='collapseTwo339$codproduto'>
                                                    a Receber   
                                                </a>
                                            </div>
                                            <div id='collapseTwo339$codproduto' class='collapse card' style='margin: 5px;' aria-labelledby='headingTwo339$codproduto' data-parent='#accordion'>
                                                <form method='post' name='frmCadastro' id='frmCadastro' novalidate enctype='multipart/form-data'>
                                                    <input type='hidden' name='txtCod_soli' id='txtCod_soli' value='$cod_solicitacoes' />
                                                    <input type='hidden' name='txtCod_orgao' id='txtCod_orgao' value='" . $_SESSION['cod_orgaoF'] . "' />
                                                    <input type='hidden' name='txtCodproduto' id='txtCodproduto' value='$codproduto' />
                                                    <input type='hidden' name='txtCodFuncionario' id='txtCodFuncionario' value='" . $_SESSION['codF'] . "' />
                                                    <input type='text' class='form-control' style='width:100%;' id='txtNotafiscal' name='txtNotafiscal' placeholder='Digite Nota Fiscal' value='' required='' autofocus=''>
                                                    <input style='width:100%; padding:3px;' class='btn btn-outline-success btn-lg' type='submit' name='btnCadastrarEntradaSoli' id='btnCadastrarEntradaSoli' value='Nova Entrada'/>
                                                </form>                                  

                                            </div>";
                } else if ($statusSo == 2) {
                    $variavelStatusSolicitacao = "
                                                <a class='btn btn-outline-success badge-pill'>
                                                    Recebido   
                                                </a>
                                           ";
                }

                $sql466 = mysqli_query($conn, "SELECT * FROM funcionarios WHERE cod = $cod_funcionarioSo ORDER BY cod DESC LIMIT 1");

                // Exibe todos os valores encontrados
                while ($func = mysqli_fetch_object($sql466)) {
                    $cod_funcionarioSo = $func->nome;
                }
            }

            $sqlOr = mysqli_query($conn, "SELECT * FROM orgaos ORDER BY cod ASC");
            $optionOrgaos = "";
            // Exibe todos os valores encontrados
            while ($orgaos = mysqli_fetch_object($sqlOr)) {
                $optionOrgaos = $optionOrgaos . "<option value='$orgaos->cod'>$orgaos->nome</option>";
            }



            echo "
            <div class='card' style='margin:15px;'>
                <div class='card-body'>
                    <div class='row'>
                        <div class='col-3 col-md-3'>
                            <small><b>Descrição</b>: $descricao</small>
                            </br>
                            <small><b>Qtd.</b>: $qtd</small>
                            </br>
                            <small><b>Status.</b>: $statusp</small>
                                
                        </div>
                        <div class='col-9 col-md-9' style='text-align:center;'>
                                     <a style='' class='btn btn-outline-info badge-pill' data-toggle='collapse' data-target='#collapseTwo343$codproduto' aria-expanded='false' aria-controls='collapseTwo343$codproduto'>
                                        Entradas   
                                    </a>
                                     <a style='' class='btn btn-outline-info badge-pill' data-toggle='collapse' data-target='#collapseTwo344$codproduto' aria-expanded='false' aria-controls='collapseTwo344$codproduto'>
                                        Saídas   
                                    </a>
                                    
                                    <div id='collapseTwo343$codproduto' class='collapse card' style='margin: 5px;' aria-labelledby='headingTwo343$codproduto' data-parent='#accordion'>
                                         <table class='table table-bordered table-light table-striped'>
                                            <thead>
                                            <tr>
                                                <th>Funcionário</th>
                                                <th>Nota Fiscal</th>
                                                <th>Última Entrada</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td><b>$cod_funcionario</b></td>
                                                <td><a class='btn btn-outline-info badge-pill' href='?pagina=entradas&cod=$codentrada'> <b>$notafiscal</b></a></td>
                                                <td><b>$dia/$mes/$ano</b></td>
                                            </tr>
                                            <tr>
                                                    <td colspan='3'>
                                                     <form method='post' name='frmCadastro' id='frmCadastro' novalidate enctype='multipart/form-data'>
                                                    <input type='hidden' name='txtCod_orgao' id='txtCod_orgao' value='" . $_SESSION['cod_orgaoF'] . "' />
                                                    <input type='hidden' name='txtCodproduto' id='txtCodproduto' value='$codproduto' />
                                                    <input type='hidden' name='txtCodFuncionario' id='txtCodFuncionario' value='" . $_SESSION['codF'] . "' />
                                                    <input type='text' class='form-control' style='width:100%;' id='txtConferidor1' name='txtConferidor1' placeholder='Digite o nome do conferidor 1' value='' required='' autofocus=''>
                                                    <input type='text' class='form-control' style='width:100%;' id='txtConferidor2' name='txtConferidor2' placeholder='Digite o nome do conferidor 2' value='' required='' autofocus=''>
                                                    <input type='text' class='form-control' style='width:100%;' id='txtConferidor3' name='txtConferidor3' placeholder='Digite o nome do conferidor 3' value='' required='' autofocus=''>
                                                    
                                                    <input type='text' class='form-control' style='width:100%;' id='txtNotafiscal' name='txtNotafiscal' placeholder='Digite Nota Fiscal' value='' required='' autofocus=''>
                                                    <input style='width:100%; padding:3px;' class='btn btn-outline-success btn-lg' type='submit' name='btnCadastrarEntrada' id='btnCadastrarEntrada' value='Nova Entrada'/>
                                                    </form>                                                                                                       
                                                  </td>

                                            </tr>
                                         </table>
                                       
                                    </div>
                                    <div id='collapseTwo344$codproduto' class='collapse card' style='margin: 5px;' aria-labelledby='headingTwo344$codproduto' data-parent='#accordion'>
                                         <table class='table table-bordered table-light table-striped'>
                                            <thead>
                                            <tr>
                                                <th>Destinatário</th>
                                                <th>Funcionário</th>
                                                <th>Status</th>
                                                <th>Última Saída</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td><b>$cod_destinatarioS</b></td>
                                                <td><b>$cod_funcionarioS</b></td>
                                                <td><a class='btn btn-outline-info badge-pill' href='?pagina=saidas&cod=$cod_saida'> <b>$textoStatusS</b></a></td>
                                                <td><b>$diaS/$mesS/$anoS</b></td>
                                            </tr>
                                            <tr>
                                                    <td colspan='4'>
                                                        <form method='post' name='frmCadastro' id='frmCadastro' novalidate enctype='multipart/form-data'>
                                                        Destinátario
                                                        <select name='txtCod_destinatario' id='txtCod_destinatario' class='form-control' style='width:100%; margin-bottom:5px;'>
                                                            $optionOrgaos
                                                        </select>
                                                        <input type='hidden' name='txtCod_funcionario' id='txtCod_funcionario' value='$cod_func' />
                                                        <input type='hidden' name='txtCod_orgao' id='txtCod_orgao' value='$cod_org' />
                                                        <input style='width:100%; padding:3px;' class='btn btn-outline-warning btn-lg' type='submit' name='btnCadastrarSaida' id='btnCadastrarCancelarEntrada' value='Nova saída'/>
                                                        </form>
                                                    </td>
                                            </tr>
                                         </table>
                                    </div>
                                     <div id='collapseTwo345$codproduto' class='collapse card' style='margin: 5px;' aria-labelledby='headingTwo345$codproduto' data-parent='#accordion'>
                                         <table class='table table-bordered table-light table-striped'>
                                            <thead>
                                            <tr>
                                                <th>Qtd</th>
                                                <th>Funcionário</th>
                                                <th>Status</th>
                                                <th>Última Solicitação</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td><b>$qtdSo</b></td>
                                                <td><b>$cod_funcionarioSo</b></td>
                                                <td>
                                                    $variavelStatusSolicitacao
                                                </td>
                                                <td><b>$diaSo/$mesSo/$anoSo</b></td>
                                            </tr>
                                            <tr>
                                                    <td colspan='4'>
                                                        <form method='post' name='frmCadastro' id='frmCadastro' novalidate enctype='multipart/form-data'>
                                                            <b>Qtd Solicitada:</b>
                                                            <input type='text' name='txtQtdSoli' id='txtQtdSoli' value='' class='form-control' />
                                                            <input type='hidden' name='txtCod_prod' id='txtCod_prod' value='$codproduto' />
                                                            <input style='width:100%; padding:3px;' class='btn btn-outline-primary btn-lg' style='' type='submit' name='btnCadastrarSolicitarEs' id='btnCadastrarSolicitarEs' value='Solicitar'/>
                                                            </form> 
                                                        </td>
                                            </tr>
                                         </table>
            
                                    </div>
                                    <div id='collapseTwo33$codproduto' class='collapse card' style='margin: 5px;' aria-labelledby='headingTwo33$codproduto' data-parent='#accordion'>
                                    EDITAR
                                </div>
                        </div>
                        </div>    
                    </div>
                </div>
            </div>
            
";
        }
        break;

    case 7:
        $sql = mysqli_query($conn, "SELECT * FROM produtos WHERE descricao LIKE '%" . $valor . "%'  ORDER BY cod DESC");

        // Exibe todos os valores encontrados
        while ($produtos = mysqli_fetch_object($sql)) {
            $codproduto = $produtos->cod;
            $apresentacao = $produtos->apresentacao;
            $qtd = $produtos->qtd;
            $tipo = $produtos->tipo;
            $status = $produtos->status;
            $fornecedor = $produtos->fornecedor;
            $cod_orgaoF = $produtos->cod_orgao;
            $est_mim = $produtos->est_mim;
            $est_max = $produtos->est_max;
            $cod_barra = $produtos->cod_barra;
            $descricao = $produtos->descricao;
            $img = $produtos->img;
            $valorunt = number_format($produtos->valor, 2, ',', '.');
            $categoria = $produtos->categoria;
            $sql2 = mysqli_query($conn, "SELECT * FROM categoria_produto WHERE cod=" . $categoria . " LIMIT 1");
            while ($categorias = mysqli_fetch_object($sql2)) {
                $nomecategoria = $categorias->nome;
            }
            if ($img == null) {
                $img = "LOGOSEMSA.png";
            }
            $cod_entrada_saida = $param;
            echo "
            <div class='card' style='margin:15px;'>
                <div class='card-body'>
                    <div class='row'>
                        <div class='col-12 col-md-12' style='text-align:center;'>
                        
                        <a style='width:100%;' href=\"javascript:func()\" onclick=\"buscarProdutos(8, " . $codproduto . ", '" . $cod_entrada_saida . "')\" style='margin:5px;' class=\"btn btn-outline-secondary btn-lg\">
                                         <small style='color:blue;'>Descricao:</small>$descricao </br> <small style='color:blue;'>Qtd:</small> $qtd </br> <small style='color:blue;'>Est. Min.:</small>$est_mim 
                                       </a>
                                       
                        </div>
                    </div>
                </div> 
            </div>
            ";
            header("Content-Type: text/html; charset=ISO-8859-1", true);

        }
        
        break;

    case 8:
        $cod_listaentrada = $_GET['valor'];

        $cod_produto = $_GET['param'];

        $sql = mysqli_query($conn, "SELECT * FROM produtos WHERE cod = $cod_produto ORDER BY cod DESC LIMIT 1");

// Exibe todos os valores encontrados
        while ($produtos = mysqli_fetch_object($sql)) {
            $codproduto = $produtos->cod;
            $apresentacao = $produtos->apresentacao;
            $qtd = $produtos->qtd;
            $tipo = $produtos->tipo;
            $status = $produtos->status;
            $fornecedor = $produtos->fornecedor;
            $cod_orgaoF = $produtos->cod_orgao;
            $est_mim = $produtos->est_mim;
            $est_max = $produtos->est_max;
            $cod_barra = $produtos->cod_barra;
            $descricao = $produtos->descricao;
            $img = $produtos->img;
            $valor_produto = number_format($produtos->valor, 2, ',', '.');
            $valor_produto2 = $produtos->valor;
            $categoria = $produtos->categoria;
            $sql2 = mysqli_query($conn, "SELECT * FROM categoria_produto WHERE cod=" . $categoria . " LIMIT 1");
            while ($categorias = mysqli_fetch_object($sql2)) {
                $nomecategoria = $categorias->nome;
            }
            if ($img == null) {
                $img = "LOGOSEMSA.png";
            }
        }

        echo "<form method='post' name='frmCadastro' id='frmCadastro' novalidate enctype='multipart/form-data'>
                                        <div class='row' style='margin-bottom: 10px;'>
                                            <div class='col-6 col-md-6'>
                                                <label for='txtLote'>Lote:</label>
                                                <input type='text' class='form-control' id='txtLote' name='txtLote' placeholder='' value='' autofocus=''/>
                                            </div> 
                                            <div class='col-6 col-md-6'>
                                                <label for='txtValidade'>Validade:</label>
                                                <input type='text' class='form-control' id='txtValidade' name='txtValidade' placeholder='' value='' required=''/>
                                            </div>
                                            <div class='col-6 col-md-6'>
                                                <label for='txtQtd'>Qtd:</label>
                                                <input type='text' class='form-control' id='txtQtd' name='txtQtd' placeholder='' value='' required='' onkeyup='Validacao(1, this.value, $valor_produto2)' />
                                            </div>
                                            <div class='col-6 col-md-6' id='resultadoqtdvalor'>
                                                <label for='txtValor_total'>Total:</label>
                                                <input type='text' class='form-control' id='txtValor_total' name='txtValor_total' placeholder='' value='$valor_produto2' required='' disabled='' />
                                                <input type='hidden' name='txtValor_total' id='txtValor_total' value='$valor_produto2' />
                                            </div>
                                        </div>
                                        <input type='hidden' name='txtCod_entrada' id='txtCod_entrada' value='$cod_listaentrada' />
                                        <input type='hidden' name='txtCod_produto' id='txtCod_produto' value='$cod_produto' />
                                        <input class='btn btn-outline-success btn-lg' style='width: 100%;' type='submit' name='btnCadastrarListEntrada' id='btnCadastrarListEntrada' value='Cadastrar Produto'/>

                                    </form>";

        break;
        
        case 9:
        $sql = mysqli_query($conn, "SELECT * FROM produtos WHERE descricao LIKE '%" . $valor . "%'  ORDER BY cod DESC");

// Exibe todos os valores encontrados
        while ($produtos = mysqli_fetch_object($sql)) {
            $codproduto = $produtos->cod;
            $apresentacao = $produtos->apresentacao;
            $qtdAtual = $produtos->qtd;
            $tipo = $produtos->tipo;
            $status = $produtos->status;
            $fornecedor = $produtos->fornecedor;
            $cod_orgaoF = $produtos->cod_orgao;
            $est_mim = $produtos->est_mim;
            $est_max = $produtos->est_max;
            $cod_barra = $produtos->cod_barra;
            $descricao = $produtos->descricao;
            $img = $produtos->img;
            $valorunt = number_format($produtos->valor, 2, ',', '.');
            $categoria = $produtos->categoria;
            $sql2 = mysqli_query($conn, "SELECT * FROM categoria_produto WHERE cod=" . $categoria . " LIMIT 1");
            while ($categorias = mysqli_fetch_object($sql2)) {
                $nomecategoria = $categorias->nome;
            }
            if ($img == null) {
                $img = "LOGOSEMSA.png";
            }


            echo "
                        <div class='card' style='margin:15px;'>
                <div class='card-body'>
                    <div class='row'>
                        
                        <div class='col-12 col-md-12'>
                            <small><b>Descricao</b>: $descricao</small>
                            </br>
                            <small><b>Qtd Atual</b>:$qtdAtual</small>
                            </br>
                            <small><b>Est min..</b>: $est_mim</small>
                        </div>
                        </div>    
                    </div>
                </div>
            </div> ";
        header("Content-Type: text/html; charset=ISO-8859-1", true);
        
            
            }
        
        break;

}
?>