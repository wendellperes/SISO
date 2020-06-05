<?php
require_once("Banco.php");

class CategoriaSerFinDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(CategoriaSerFin $categoriaserfin) {
        try {
            $sql = "INSERT categoriaserfin (nome) VALUES (:nome)";

            $param = array(
                ":nome" => $categoriaserfin->getNome()
            );

            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

    public function Alterar(CategoriaSerFin $categoriaserfin) {
        try {
            $sql = "UPDATE categoriaserfin SET nome = :nome WHERE cod = :cod";

            $param = array(
                ":cod" => $categoriaserfin->getId(),
                ":nome" => $categoriaserfin->getNome()  
            );

            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

    public function RetornarCategorias() {
        try {
            $sql = "SELECT * FROM categoriaserfin ORDER BY cod ASC";

            $dt = $this->pdo->ExecuteQuery($sql);
            $listaCategoriaserfin = [];

            foreach ($dt as $dr) {
                $categoriaserfin = new CategoriaSerFin();

                $categoriaserfin->setId($dr["cod"]);
                $categoriaserfin->setNome($dr["nome"]);

                $listaCategoriaserfin[] = $categoriaserfin;
            }

            return $listaCategoriaserfin;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarCategorias2(int $cod) {
        try {
            $sql = "SELECT * FROM categoriaserfin WHERE cod = :cod ORDER BY cod ASC";
            $param = array(
                   ":cod" => $cod 
            );  
            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaCategoriaserfin = [];

            foreach ($dt as $dr) {
                $categoriaserfin = new CategoriaSerFin();

                $categoriaserfin->setId($dr["cod"]);
                $categoriaserfin->setNome($dr["nome"]);

                $listaCategoriaserfin[] = $categoriaserfin;
            }

            return $listaCategoriaserfin;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarNomeCat(int $id) {
        try {

            $sql = "SELECT * FROM categoriaserfin WHERE cod = :cod  ORDER BY cod ASC";
            $param = array(
                ":cod" => $id
            );

            $dataTable = $this->pdo->ExecuteQuery($sql, $param);


            foreach ($dataTable as $resultado) {
                $nome = $resultado["nome"];

                $nomefulano = $nome;
            }

            return $nomefulano;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

}
?>