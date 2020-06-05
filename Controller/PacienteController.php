<?php

if (file_exists("../DAL/PacienteDAO.php")) {
    require_once("../DAL/PacienteDAO.php");
} else if (file_exists("DAL/PacienteDAO.php")) {
    require_once("DAL/PacienteDAO.php");
} else {
    require_once("../../DAL/PacienteDAO.php");
}

class PacienteController {

    private $pacienteDAO;

    public function __construct() {
        $this->pacienteDAO = new PacienteDAO();
    }

    public function Cadastrar($paciente) {
        if (
                strlen($paciente->getNome()) >= 5
        ) {
            return $this->pacienteDAO->Cadastrar($paciente);
        } else {
            return false;
        }
    }

    public function RetornarPacientes(string $termo, int $tipo, int $status) {
        if (strlen($termo) >= 0 && $tipo > 0 && $status >= 0) {
            return $this->pacienteDAO->RetornarPacientes($termo, $tipo, $status);
        } else {
            return false;
        }
    }

    public function RetornarAtivosInativos(int $tipo) {
        if (0 == 0) {
            return $this->pacienteDAO->RetornarAtivosInativos($tipo);
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

    public function RetornarUltimoPaciente() {
        if (1 == 1) {
            return $this->pacienteDAO->RetornarUltimoPaciente();
        } else {
            return false;
        }
    }

    public function RetornarNomePac(int $id) {
        if (1 == 1) {
 
            return $this->pacienteDAO->RetornarNomePac($id);
        } else {
            return null;
        }
    }
    
    public function AlterarIna(int $status, int $cod) {
        if ($cod != 0) {
            return $this->pacienteDAO->AlterarIna($status, $cod);
        } else {
            return null;
        }
    }

}
