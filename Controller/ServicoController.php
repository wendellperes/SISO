<?php

if (file_exists("../DAL/ServicoDAO.php")) {
    require_once("../DAL/ServicoDAO.php");
} else {
    require_once("DAL/ServicoDAO.php");
}

class ServicoController {

    private $servicoDAO;

    public function __construct() {
        $this->servicoDAO = new ServicoDAO();
    }

    public function Cadastrar($servico) {
        if (
                strlen($servico->getNome()) >= 1) {
            return $this->servicoDAO->Cadastrar($servico);
        } else {
            return false;
        }
    }

    public function Deletar(int $coddeletar) {
        if ($coddeletar != 0) {
            return $this->servicoDAO->Deletar($coddeletar);
        } else {
            return false;
        }
    }

    public function RetornarServicos() {
        if (1 == 1) {
            return $this->servicoDAO->RetornarServicos();
        } else {
            return false;
        }
    }

    public function RetornarServicos2(int $id) {
        if ($id != 0) {
            return $this->servicoDAO->RetornarServicos2($id);
        } else {
            return false;
        }
    }

    public function RetornarServicosPorCat(int $cat, string $termo) {
        if ($cat != 0) {
            return $this->servicoDAO->RetornarServicosPorCat($cat, $termo);
        } else {
            return false;
        }
    }

    public function Alterar($servico) {
        if (
                strlen($servico->getNome()) >= 1
        ) {
            return $this->servicoDAO->Alterar($servico);
        } else {
            return false;
        }
    }

}
