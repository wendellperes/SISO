<?php

if (file_exists("../DAL/CategoriaFinanceiroDAO.php")) {
    require_once("../DAL/CategoriaFinanceiroDAO.php");
} elseif (file_exists("DAL/CategoriaFinanceiroDAO.php")) {
    require_once("DAL/CategoriaFinanceiroDAO.php");
}

class CategoriaFinanceiroController {

    private $CategoriaFinanceiroDAO;

    function __construct() {
        $this->CategoriaFinanceiroDAO = new CategoriaFinanceiroDAO();
    }

    public function Cadastrar(CategoriaFinanceiro $categoriafinanceiro) {
        if (
                $categoriafinanceiro->getCod_usu() > 0) {
            return $this->CategoriaFinanceiroDAO->Cadastrar($categoriafinanceiro);
        } else {
            return false;
        }
    }

    public function RetornarNomeCat(int $cod) {
        if ($cod > 0) {
            return $this->CategoriaFinanceiroDAO->RetornarNomeCat($cod);
        } else {
            return null;
        }
    }

    public function RetornarCategorias(int $cod) {
        if ($cod > 0) {
            return $this->CategoriaFinanceiroDAO->RetornarCategorias($cod);
        } else {
            return null;
        }
    }

    public function Deletar2(int $coddeletar) {
        if ($coddeletar != 0) {
            return $this->CategoriaFinanceiroDAO->Deletar2($coddeletar);
        } else {
            return false;
        }
    }

}

?>