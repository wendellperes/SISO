<?php

if (file_exists("../DAL/MovimentoPacDAO.php")) {
    require_once("../DAL/MovimentoPacDAO.php");
} elseif (file_exists("DAL/MovimentoPacDAO.php")) {
    require_once("DAL/MovimentoPacDAO.php");
}

class MovimentoPacController {

    private $movimentopacDAO;

    function __construct() {
        $this->movimentopacDAO = new MovimentoPacDAO();
    }

    public function Cadastrar(MovimentoPac $movimentopac) {
        if (1 == 1) {

            return $this->movimentopacDAO->Cadastrar($movimentopac);
        } else {
            return false;
        }
    }

    public function RetornarMes(int $mes, int $ano) {

        if ($mes != 0) {
            return $this->movimentopacDAO->RetornarMes($mes, $ano);
        } else {
            return null;
        }
    }
    
     public function RetornarCobranca(int $cod) {

        if ($cod != 0) {
            return $this->movimentopacDAO->RetornarCobranca($cod);
        } else {
            return null;
        }
    }

    public function RetornarMesAP(int $ativopassivo, int $mes, int $ano) {

        if ($mes != 0) {
            return $this->movimentopacDAO->RetornarMesAP($ativopassivo, $mes, $ano);
        } else {
            return null;
        }
    }

    public function RetornarAno(int $ano) {

        if ($ano != 0) {
            return $this->movimentopacDAO->RetornarAno($ano);
        } else {
            return null;
        }
    }

    public function RetornarPac(int $cod, int $tipo) {

        if ($cod != 0) {
            return $this->movimentopacDAO->RetornarPac($cod, $tipo);
        } else {
            return null;
        }
    }

    public function RetornarPorCategoria(int $cod, int $mes, int $ano, int $categoria) {

        if (
                $cod > 0) {
            return $this->movimentopacDAO->RetornarPorCategoria($cod, $mes, $ano, $categoria);
        } else {
            return null;
        }
    }

    public function RetornarTodos(int $cod, int $ano) {

        if (
                $cod > 0
        ) {
            return $this->movimentopacDAO->RetornarTodos($cod, $ano);
        } else {
            return null;
        }
    }

    public function RetornarMovimentoPacMesCat(int $mes, int $ano) {
        if (  $mes != 0 && $ano != 0) {
            
            return $this->movimentopacDAO->RetornarMovimentoPacMesCat($mes, $ano);
        } else {
            return false;
        }
    }
    
     public function RetornarMovimentoCob(int $mes, int $ano) {
        if (  $mes != 0 && $ano != 0) {
            
            return $this->movimentopacDAO->RetornarMovimentoCob($mes, $ano);
            
        } else {
            return false;
        }
    }
    
     public function Pagar(int $tipo, int $cod) {

        if ($cod != 0) {
            return $this->movimentopacDAO->Pagar($tipo, $cod);
        } else {
            return null;
        }
    }
    
    public function RetornarAtraso(int $cod) {
        if ($cod != 0) {
            return $this->movimentopacDAO->RetornarAtraso($cod);
        } else {
            return null;
        }
    }
    
     public function RetornarUltPag(int $cod) {
        if ($cod != 0) {
            return $this->movimentopacDAO->RetornarUltPag($cod);
        } else {
            return null;
        }
    }
    
    public function DeletarPagamentos(int $coddeletar) {
        if ($coddeletar!=0) {
            return $this->movimentopacDAO->DeletarPagamentos($coddeletar);
        } else {
            return false;
        }
    }
    
}

?>