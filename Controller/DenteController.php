<?php

if (file_exists("../DAL/DenteDAO.php")) {
    require_once("../DAL/DenteDAO.php");
} else {
    require_once("DAL/DenteDAO.php");
}

class DenteController {

    private $denteDAO;

    public function __construct() {
        $this->denteDAO = new DenteDAO();
    }

    public function Cadastrar($dente) {
        if (
                strlen($dente->getNome()) >= 1) {
            return $this->denteDAO->Cadastrar($dente);
        } else {
            return false;
        }
    }

    public function Deletar(int $coddeletar) {
        if ($coddeletar != 0) {
            return $this->denteDAO->Deletar($coddeletar);
        } else {
            return false;
        }
    }

    public function RetornarDentes() {
        if (1 == 1) {
            return $this->denteDAO->RetornarDentes();
        } else {
            return false;
        }
    }

    public function RetornarDentes2(int $id) {
        if ($id != 0) {
            return $this->denteDAO->RetornarDentes2($id);
        } else {
            return false;
        }
    }

    public function RetornarDentesQ(int $q) {
        if ($q != 0) {
            return $this->denteDAO->RetornarDentesQ($q);
        } else {
            return false;
        }
    }

    public function Alterar($dente) {
        if (
                strlen($dente->getNome()) >= 1
        ) {
            return $this->denteDAO->Alterar($dente);
        } else {
            return false;
        }
    }

}
