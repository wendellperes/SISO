<?php

if (file_exists("../DAL/PagParProDAO.php")) {
    require_once("../DAL/PagParProDAO.php");
} elseif (file_exists("DAL/PagParProDAO.php")) {
    require_once("DAL/PagParProDAO.php");
}

class PagParProController {

    private $pagparproDAO;

    function __construct() {
        $this->pagparproDAO = new PagParProDAO();
    }

    public function Cadastrar(PagParPro $pagparpro) {
        if (
                $pagparpro->getFinanceiro_pac() > 0) {
            return $this->pagparproDAO->Cadastrar($pagparpro);
        } else {
            return false;
        }
    }

    public function RetornarMes(int $cod, int $mes, int $ano) {

        if ( $cod > 0) {
            return $this->pagparproDAO->RetornarMes($cod, $mes, $ano);
        } else {
            return null;
        }
    }

    public function RetornarPorCategoria(int $cod, int $mes, int $ano, int $categoria) {

        if (
                $cod > 0) {
            return $this->movimentoDAO->RetornarPorCategoria($cod, $mes, $ano, $categoria);
        } else {
            return null;
        }
    }

    public function RetornarTodos(int $cod) {

        if ($cod > 0) {
            return $this->pagparproDAO->RetornarTodos($cod);
        } else {
            return null;
        }
    }

    public function RetornarM(int $cod) {

        if ($cod > 0) {
            return $this->pagparproDAO->RetornarM($cod);
        } else {
            return null;
        }
    }


}

?>