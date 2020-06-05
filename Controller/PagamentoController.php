<?php

if (file_exists("../DAL/PagamentoDAO.php")) {
    require_once("../DAL/PagamentoDAO.php");
} else {
    require_once("DAL/PagamentoDAO.php");
}

class PagamentoController {

    private $pagamentoDAO;

    public function __construct() {
        $this->pagamentoDAO = new PagamentoDAO();
    }

    public function Cadastrar($pagamento) {
        if (($pagamento->getCod_orcamento()) != 0) {
            return $this->pagamentoDAO->Cadastrar($pagamento);
        } else {
            return false;
        }
    }
    
     public function Deletar(int $coddeletar) {
        if ($coddeletar!=0) {
            return $this->pagamentoDAO->Deletar($coddeletar);
        } else {
            return false;
        }
    }
    
    public function RetornarPagamentos( int $id) {
        if (1==1) {
            return $this->pagamentoDAO->RetornarPagamentos($id);
        } else {
            return false;
        }
    }
    
    public function RetornarPagamentos2(int $mes, int $ano, int $categoria) {
        if (1==1) {
            return $this->pagamentoDAO->RetornarPagamentos2($mes, $ano, $categoria);
        } else {
            return false;
        }
    }
    
    
    
 
}
