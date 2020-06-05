<?php

if (file_exists("../DAL/AnamneseDAO.php")) {
    require_once("../DAL/AnamneseDAO.php");
} else {
    require_once("DAL/AnamneseDAO.php");
}

class AnamneseController {

    private $anamneseDAO;

    public function __construct() {
        $this->anamneseDAO = new AnamneseDAO();
    }

    public function Cadastrar($anamnese) {
        if (
                ($anamnese->getCod_usu()) >= 1
        ) {
            return $this->anamneseDAO->Cadastrar($anamnese);
        } else {
            return false;
        }
    }
    
    public function RetornarAnamnese(string $termo, int $cod_usu2, int $tipo) {
        if (strlen($termo) >= 0 && $cod_usu2>0 && $tipo>0) {
            return $this->anamneseDAO->RetornarAnamnese($termo, $cod_usu2, $tipo);
        } else {
            return false;
        }
    }
    
    public function VerificaCPFExiste(string $cpf) {
        if (strlen($cpf) == 14) {
            return $this->pacienteDAO->VerificaCPFExiste($cpf);
        } else {
            -10;
        }
    }
    
    public function Alterar($paciente) {
        if (
                strlen($paciente->getNome()) >= 5
        ) {
            return $this->pacienteDAO->Alterar($paciente);
        } else {
            return false;
        }
    }

}
