<?php

if (file_exists("../DAL/CategoriaSerFinDAO.php")) {
    require_once("../DAL/CategoriaSerFinDAO.php");
} elseif (file_exists("DAL/CategoriaSerFinDAO.php")) {
    require_once("DAL/CategoriaSerFinDAO.php");
}

class CategoriaSerFinController {

    private $CategoriaSerFinDAO;

    function __construct() {
        $this->CategoriaSerFinDAO = new CategoriaSerFinDAO();
    }

    public function Cadastrar(CategoriaSerFin $categoriaserfin) {
        if ($categoriaserfin->getNome() != null) {
            return $this->CategoriaSerFinDAO->Cadastrar($categoriaserfin);
        } else {
            return false;
        }
    }

    public function Alterar(CategoriaSerFin $categoriaserfin) {
        if ($categoriaserfin->getNome() != null) {
            
            return $this->CategoriaSerFinDAO->Alterar($categoriaserfin);
        } else {
            return false;
        }
    }

    public function RetornarCategorias() {
        if (1==1) {
            return $this->CategoriaSerFinDAO->RetornarCategorias();
        } else {
            return null;
        }
    }
    public function RetornarCategorias2(int $cod) {
        if ($cod > 0) {
            return $this->CategoriaSerFinDAO->RetornarCategorias2($cod);
        } else {
            return null;
        }
    }
    
    public function RetornarNomeCat(int $id) {
        if (1==1) {
            return $this->CategoriaSerFinDAO->RetornarNomeCat($id);
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

  

}

?>