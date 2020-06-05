<?php

if (file_exists("../DAL/ListaEsperaDAO.php")) {
    require_once("../DAL/ListaEsperaDAO.php");
} else {
    require_once("DAL/ListaEsperaDAO.php");
}

class ListaesperaController {

    private $listaesperaDAO;

    public function __construct() {
        $this->listaesperaDAO = new ListaesperaDAO();
    }

    public function Cadastrar($listaespera) {
        if (
                strlen($listaespera->getCod_paciente()) >= 1) {
            return $this->listaesperaDAO->Cadastrar($listaespera);
        } else {
            return false;
        }
    }
    
     public function DeletarEspera(int $coddeletar) {
        if ($coddeletar!=0) {
            return $this->listaesperaDAO->DeletarEspera($coddeletar);
        } else {
            return false;
        }
    }
    
     public function DeletarEvento(int $coddeletar) {
        if ($coddeletar!=0) {
            return $this->listaesperaDAO->DeletarEvento($coddeletar);
        } else {
            return false;
        }
    }
    
    public function RetornarListaEspera() {
        if (1==1) {
            return $this->listaesperaDAO->RetornarListaEspera();
        } else {
            return false;
        }
    }
    
    

}

?>