<?php
date_default_timezone_set('America/Manaus');

require_once("../Model/Usuarios.php");
require_once("../Model/Clientes.php");
require_once("../Model/Notas.php");
require_once("../Model/Pedidos.php");
require_once("../Model/Servicos.php");
require_once("../Model/CategoriaSerFin.php");



require_once("../Controller/NotasController.php");
require_once("../Controller/ClientesController.php");
require_once("../Controller/UsuariosController.php");
require_once("../Controller/NotasController.php");
require_once("../Controller/PedidosController.php");
require_once("../Controller/ServicoController.php");
require_once("../Controller/CategoriaSerFinController.php");

$notasController = new NotasController();
$clientesController = new ClientesController();
$usuarioController = new UsuarioController();
$notasController = new NotasController();
$servicoController = new ServicoController();
$pedidosController = new PedidosController;
$categoriaserfinController = new CategoriaSerFinController();




$cod = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
$tipo = 2;

$listaNotas = $notasController->RetornarNotas($tipo, $cod);

if ($listaNotas != null) {
    foreach ($listaNotas as $user4) {
        $o = $user4->getCod();
        $codusuario = $user4->getUsuario();
        $termo = "Nós é zika irmão";
        $tipo = 1;
        $status = $o;
        $listaPedidos = $pedidosController->RetornarPedidos($termo, $tipo, $status);

        $cont = 0;
        $qtdfinal = 0;
        $valorTotal = 0;

        $meiotermo = "";
        $finaltermo = "";

        if ($listaPedidos != null) {
            foreach ($listaPedidos as $user4) {
                if ($user4->getStatus() != 0) {
                    $cont++;
                    $cod_dente = $user4->getDente();
                    $cod_servico = $user4->getServico();
                    $cod_proc = $user4->getCod();
                    $statuspedido = $user4->getStatus();
                    $categoriaproduto = $user4->getCategoria();

                    $qtd = $user4->getQtd();
                    $valor_procedimento = $user4->getValor();
                    $string = $valor_procedimento;
                    $stringCorrigida = str_replace(',', '', $string);
                    if ($statuspedido != 0) {
                        $valorTotal = $valorTotal + $stringCorrigida;

                        $qtdfinal = $qtdfinal + $qtd;
                    }
                    $valor_procedimento = number_format($stringCorrigida, 2, ',', '.');

                    $obs = $user4->getObs();
                    if ($cod_servico != 0) {
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
                        $nomeCategoria = $categoriaserfinController->RetornarNomeCat($categoriaproduto);
                        $meiotermo = $meiotermo . "<tr style='color: #fff;'>
                                    <td>
                                     $qtd
                                    </td>
                                    <td colspan='2'>
                                         $nome <small>($nomeCategoria)</small>
                                    </td>
                                    <td>
                                        R$  $valor_procedimento
                                    </td>
                                    </tr> 
                                    <tr>
                                    <td colspan='4'>
                                        Obs:   $obs 
                                    </td>
                                    </tr>
                                    
                   <tr>
                    <td colspan='4'>
                -------------------------------------------------------------------------------
                       </td>
                   </tr>
                                    ";
                    } else {
                        $meiotermo = $meiotermo . "
                            <tr style='color: #fff;'>
                            <td>
                                 $qtd
                            </td>
                            <td colspan='2'>
                                $obs
                            </td>
                            <td>
                                R$ $valor_procedimento
                            </td>
                        </tr>
                        
                   <tr>
                    <td colspan='4'>
                -------------------------------------------------------------------------------
                       </td>
                   </tr>
                                    ";
                    }
                }
            }
        }
        $string = $valorTotal;
        $stringCorrigida = str_replace(',', '', $string);
        $valorTotal = number_format($stringCorrigida, 2, ',', '.');

        $finaltermo = "
            
                   
            <tr>
                <td>Qtd de pedidos:</td>
                <th scope='row'> $qtdfinal </th>
                <td>Valor Final:</td>
                <th scope='row'>
                R$ $valorTotal     
                </th>
            </tr>
                <tr>
                    <td colspan='4'>
                -------------------------------------------------------------------------------
                       </td>
                   </tr>";
    }
}



if ($listaNotas != null) {
    foreach ($listaNotas as $user4) {
        $cod_paciente2 = $user4->getUsuario();
        $o = $user4->getCod();
        $cod_func = $user4->getFunc();
//$nomePaciente = $user4->getNomeCli();
        if ($cod_paciente2 == 0) {
            $nomePaciente = $user4->getNomeCli();
        } else {
            $nomePaciente = $nomepaciente3 = $clientesController->RetornarNomeClientes($cod_paciente2);
        }
        $nomeFuncionario = $usuarioController->RetornarNomeUsuarios($cod_func);
    }
}
$listaUsuariosBusca = [];

$termo = "";
$tipo = 4;
$status = 1;

$listaUsuariosBusca = $usuarioController->RetornarUsuarios($termo, $tipo, $status);

if ($listaUsuariosBusca != null) {

    foreach ($listaUsuariosBusca as $user) {
        $nome = $user->getNome();
        $email = $user->getEmail();
        $foto = $user->getFoto();
        $cpf = $user->getCpf();
        $rua = $user->getRua();
        $bairro = $user->getBairro();
        $numero = $user->getNumero();
        $celular = $user->getCelular();
    }
}


require_once("../mpdf60/mpdf.php");
$dompdf = new mPDF();
$pdf = "
            <div id=''>
                
                <div class='cabecalho'>                  
                    ** $nomeFuncionario **
                </div>
                <div class='subcabecalho'>                  
                   RUA: $rua. $numero - $bairro
                </div>
                <div class='subcabecalho'>                  
                  69460-000 / Coari - AM
                </div>
                
                <div class='subcabecalho'>                  
                  Tel: $celular 
                </div>
                
                <div class='subcabecalho'>                  
                 CNPJ: $cpf 
                </div>
                <div class='corpo'>                  
                ---------------------------------------------------------------------------
                <div style='float:left;'>
                    Cod: $o
                </div>
                <div style='float:left;'>
                 " . date('d/m/Y H:i:s') . "
                </div>    
                ---------------------------------------------------------------------------
                </div>
                <div class='corpo'>  
                    Cliente:$nomePaciente
                </div>
                   <div class='corpo'>  
                    Funcionário:$nomeFuncionario
                </div>
                <div class='corpo'>  
                ---------------------------------------------------------------------------
                </div>

                <div class='SUBcorpo'>  
                    VENDA AO CONSUMIDOR 
                </div>
                <div class='corpo'>  
                    ==============================
                </div>
                <table  style='font-size:48pt;'>
                <tr>
                    <td>Qtd</td>
                     <td colspan='2'>Descrição</td>
                      <td>Valor</td>
                   </tr>
                   <tr>
                    <td colspan='4'>
                -------------------------------------------------------------------------------
                       </td>
                   </tr>
                 $meiotermo
                $finaltermo   
                
                </table>
                 <div id='d' style='font-size:40pt';>----Deus Seja Louvado----</div>		
            </div>";
$mpdf = new mPDF();
$mpdf->SetDisplayMode('fullpage');
$css = file_get_contents("../Interface/Bootstrap/estiloPDF.css");
$mpdf->WriteHTML($css, 1);
$mpdf->WriteHTML($pdf);

$mpdf->Output();
exit;
?>