<?php

session_start();
// Incluir aquivo de conex�o
include("conn.php");

$valor = $_GET['valor'];
$tipo = $_GET['tipo'];


switch ($tipo) {
    case 1:
        $sql = mysqli_query($conn, "SELECT * FROM fornecedores WHERE descricao LIKE '%" . $valor . "%' ORDER BY cod DESC");
       
        echo "<table class='table table-bordered table-hover table-striped table-light'>";
        echo "<tr><th>Descricao</th><th>CNPJ</th><th>Endereco</th><th>Telefone</th><th></th></tr>";
// Exibe todos os valores encontrados
        while ($fornecedores = mysqli_fetch_object($sql)) {
            $codfornecedor = $fornecedores->cod;
            $cod_orgao = $fornecedores->cod_orgao;
            $descricao = $fornecedores->descricao;
            $cnpj = $fornecedores->cnpj;
            $endereco = $fornecedores->endereco;
            $telefone = $fornecedores->telefone;


            echo "
                <tr>
                    <td>$descricao</td>
                    <td>$cnpj</td>
                    <td>$endereco</td>
                    <td>$telefone</td>
                    <td>
                                    <form method='post' name='frmCadastro' id='frmCadastro' novalidate enctype='multipart/form-data'>
                                        <input type='hidden' id='txtCodFor' name='txtCodFor' value='$codfornecedor' required=''>
                                        <input class='btn btn-outline-warning btn-lg' type='submit' name='btnApagarFor' id='btnApagarFor' value='Apagar'/>
                                    </form>
                                </td>
                     
                </tr>
                                            
";
        }
        echo "</table>";
        break;
}



// header("Content-Type: text/html; charset=ISO-8859-1", true);
?>