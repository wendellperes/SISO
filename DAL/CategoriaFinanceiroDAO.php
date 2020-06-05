<?php

require_once("Banco.php");

class CategoriaFinanceiroDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(CategoriaFinanceiro $categoriafinanceiro) {
        try {
            $sql = "INSERT lc_cat (nome, cod_usu) VALUES ( :descricao, :codusu)";
            $param = array(
                ":descricao" => $categoriafinanceiro->getNome(),
                ":codusu" => $categoriafinanceiro->getCod_usu()
            );



            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

    public function RetornarCategorias(int $cod) {
        try {
			$sql = "SELECT * FROM lc_cat WHERE cod_usu = :cod ORDER BY id ASC";
            $param = array(
              ":cod" => $cod
           );
			$dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaCategoriafinanceiro  = [];

            foreach ($dt as $dr) {
                $categoriafinanceiro = new CategoriaFinanceiro();

                $categoriafinanceiro->setId($dr["id"]);
                $categoriafinanceiro->setNome($dr["nome"]);
                
                $listaCategoriafinanceiro[] = $categoriafinanceiro;
            }

            return $listaCategoriafinanceiro;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

        public function RetornarNomeCat(int $id) {
        try {

            $sql = "SELECT * FROM lc_cat WHERE id = :cod  ORDER BY id ASC";
            $param = array(
                ":cod" => $id
            );

            $dataTable = $this->pdo->ExecuteQuery($sql, $param);
            $nomefulano = "";

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
    
    public function Deletar2(int $coddeletar) {
        try {

            $sql = "DELETE FROM `lc_cat` WHERE id = :coddeletar";

            $param = array(
                ":coddeletar" => $coddeletar
            );

            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }


                }

?>