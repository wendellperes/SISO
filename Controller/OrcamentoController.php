<?php

if (file_exists("../DAL/OrcamentoDAO.php")) {
    require_once("../DAL/OrcamentoDAO.php");
} else {
    require_once("DAL/OrcamentoDAO.php");
}

class OrcamentoController {

    private $orcamentoDAO;

    public function __construct() {
        $this->orcamentoDAO = new OrcamentoDAO();
    }

    public function Cadastrar($orcamento) {
        if (
                strlen($orcamento->getUsuario()) >= 1) {
            return $this->orcamentoDAO->Cadastrar($orcamento);
        } else {
            return false;
        }
    }

     public function Deletar(int $coddeletar) {
        if ($coddeletar!=0) {
            return $this->orcamentoDAO->Deletar($coddeletar);
        } else {
            return false;
        }
    }
    
    
    public function AlterStatusTodos(int $status, int $id) {
        if ($status!=0 && $id!=0) {
            return $this->orcamentoDAO->AlterStatusTodos($status, $id);
        } else {
            echo "erro: <-Controller!";
        }
    }

    
    public function RetornarOrcamentos(int $tipo, int $id) {
        if ($tipo > 0 && $id > 0) {
            return $this->orcamentoDAO->RetornarOrcamentos($tipo, $id);
        } else {
            return false;
        }
    }
    
    public function RetornarOrcamentosConsulta(int $tipo, int $id, int $mes, int $ano) {
        if ($tipo > 0 && $id > 0) {
            return $this->orcamentoDAO->RetornarOrcamentosConsulta($tipo, $id, $mes, $ano);
        } else {
            return false;
        }
    }
    
    
     public function RetornarUltimoOrcamento(int $func) {
        if (1==1) {
            return $this->orcamentoDAO->RetornarUltimoOrcamento($func);
        } else {
            return false;
        }
    }

    public function Alterar($orcamento) {
        if (
                strlen($orcamento->getNome()) >= 1
        ) {
            return $this->orcamentoDAO->Alterar($orcamento);
        } else {
            return false;
        }
    }

}
