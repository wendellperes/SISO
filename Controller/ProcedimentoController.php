<?php

if (file_exists("../DAL/ProcedimentoDAO.php")) {
    require_once("../DAL/ProcedimentoDAO.php");
} else {
    require_once("DAL/ProcedimentoDAO.php");
}

class ProcedimentoController {

    private $procedimentoDAO;

    public function __construct() {
        $this->procedimentoDAO = new ProcedimentoDAO();
    }

    public function Cadastrar($procedimento) {
        if (
                strlen($procedimento->getValor()) >= 1) {

            return $this->procedimentoDAO->Cadastrar($procedimento);
        } else {
            return false;
        }
    }

    public function Deletar2(int $coddeletar) {
        if ($coddeletar != 0) {
            return $this->procedimentoDAO->Deletar2($coddeletar);
        } else {
            return false;
        }
    }

    
     public function DeletarO(int $coddeletar) {
        if ($coddeletar != 0) {
            return $this->procedimentoDAO->DeletarO($coddeletar);
        } else {
            return false;
        }
    }
    public function AlterStatusTodos2(int $status, int $id) {
        if ( $id != 0) {
            return $this->procedimentoDAO->AlterStatusTodos2($status, $id);
        } else {
            
        }
    }

    public function RetornarProcedimentos(string $termo, int $tipo, int $status) {
        if (strlen($termo) >= 0 && $tipo > 0 && $status >= 0) {
            return $this->procedimentoDAO->RetornarProcedimentos($termo, $tipo, $status);
        } else {
            return false;
        }
    }

    public function RetornarProcedimentosMesCat(int $categoria, int $mes, int $ano) {
        if ($categoria != 0 && $mes != 0 && $ano != 0) {
            return $this->procedimentoDAO->RetornarProcedimentosMesCat($categoria, $mes, $ano);
        } else {
            return false;
        }
    }

    public function Alterar($procedimento) {
        if (
                strlen($procedimento->getNome()) >= 1
        ) {
            return $this->procedimentoDAO->Alterar($procedimento);
        } else {
            return false;
        }
    }

}
