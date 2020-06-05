<?php

if (file_exists("../DAL/MovimentoDAO.php")) {
    require_once("../DAL/MovimentoDAO.php");
} elseif (file_exists("DAL/MovimentoDAO.php")) {
    require_once("DAL/MovimentoDAO.php");
}

class MovimentoController {

    private $movimentoDAO;

    function __construct() {
        $this->movimentoDAO = new movimentoDAO();
    }

    public function Cadastrar(Movimento $movimento) {
        if (
                $movimento->getCod_usu() > 0) {
            return $this->movimentoDAO->Cadastrar($movimento);
        } else {
            return false;
        }
    }

    public function Alterar(Classificado $classificado) {
        if (
                trim(strlen($classificado->getNome())) > 0 &&
                trim(strlen($classificado->getDescricao())) >= 10 &&
                $classificado->getValor() > 0 &&
                $classificado->getCategoria()->getCod() > 0 &&
                $classificado->getCod() > 0) {
            return $this->classificadoDAO->Alterar($classificado);
        } else {
            return false;
        }
    }

    public function RetornarMes(int $cod, int $mes, int $ano) {

        if (
                $cod > 0) {
            return $this->movimentoDAO->RetornarMes($cod, $mes, $ano);
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

    public function RetornarTodos(int $cod, int $ano) {

        if (
                $cod > 0
        ) {
            return $this->movimentoDAO->RetornarTodos($cod, $ano);
        } else {
            return null;
        }
    }

    public function RetornarProdutos(int $cod) {

        if ($cod > 0) {
            return $this->classificadoDAO->RetornarProdutos($cod);
        } else {
            return null;
        }
    }

    public function RetornarProdutosPorCat(int $cod, int $cat) {

        if ($cod > 0 && $cat > 0) {
            return $this->classificadoDAO->RetornarProdutosPorCat($cod, $cat);
        } else {
            return null;
        }
    }

    public function RetornarCod(int $cod) {
        if ($cod > 0) {
            return $this->classificadoDAO->RetornarCod($cod);
        } else {
            return null;
        }
    }

    public function RetornarCompletoCod($cod) {
        if ($cod > 0) {
            return $this->classificadoDAO->RetornarCompletoCod($cod);
        } else {
            return null;
        }
    }

    public function AlterarImagem(string $thumb, int $cod) {
        if (trim(strlen($thumb)) > 0 && $cod > 0) {
            return $this->classificadoDAO->AlterarImagem($thumb, $cod);
        } else {
            return false;
        }
    }

    public function RetornarQuantidadeRegistros(int $categoriaCod, string $termo) {
        if (strlen($termo) >= 3 && $categoriaCod > 0) {
            return $this->classificadoDAO->RetornarQuantidadeRegistros($categoriaCod, $termo);
        } else {
            return 0;
        }
    }

    public function RetornarPesquisa(int $categoriaCod, string $termo, int $inicio, int $fim) {
        if (strlen($termo) >= 3 && $categoriaCod > 0) {
            return $this->classificadoDAO->RetornarPesquisa($categoriaCod, $termo, $inicio, $fim);
        } else {
            return null;
        }
    }

    public function RetornarAnuncioClassificadoCod(int $cod) {
        if ($cod > 0) {
            return $this->classificadoDAO->RetornarAnuncioClassificadoCod($cod);
        } else {
            return null;
        }
    }

}

?>