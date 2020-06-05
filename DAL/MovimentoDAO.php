<?php

require_once("Banco.php");

class MovimentoDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(Movimento $movimento) {
        try {
            $sql = "INSERT financeiro_sorrident ( tipo, dia, mes, ano, cat, descricao, valor, cod_usu) VALUES ( :tipo, :dia, :mes, :ano, :cat, :descricao, :valor, :codusu)";

            $param = array(
                ":tipo" => $movimento->getTipo(),
                ":dia" => $movimento->getDia(),
                ":mes" => $movimento->getMes(),
                ":ano" => $movimento->getAno(),
                ":cat" => $movimento->getCat(),
                ":descricao" => $movimento->getDescricao(),
                ":valor" => $movimento->getValor(),
                ":codusu" => $movimento->getCod_usu()
            );



            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

  
    public function RetornarMes(int $cod, int $mes, int $ano) {
        try {
            $sql = "SELECT * FROM financeiro_sorrident WHERE cod_usu = :cod AND mes= :mes AND ano=:ano ORDER BY id DESC";
            $param = array(
                ":cod" => $cod,
                ":mes" => $mes,
                ":ano" => $ano
            );
            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaMovimento = [];

            foreach ($dt as $dr) {
                $movimento = new Movimento();

                $movimento->setId($dr["id"]);
                $movimento->setTipo($dr["tipo"]);
                $movimento->setDia($dr["dia"]);
                $movimento->setMes($dr["mes"]);
                $movimento->setAno($dr["ano"]);
                $movimento->setCat($dr["cat"]);
                $movimento->setDescricao($dr["descricao"]);
                $movimento->setValor($dr["valor"]);

                $listaMovimento[] = $movimento;
            }

            return $listaMovimento;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarPorCategoria(int $cod, int $mes, int $ano, int $categoria) {
        try {
            $sql = "SELECT * FROM financeiro_sorrident WHERE cod_usu = :cod AND mes= :mes AND ano=:ano AND cat = :categoria ORDER BY id DESC";
            $param = array(
                ":cod" => $cod,
                ":mes" => $mes,
                ":ano" => $ano,
                ":categoria" => $categoria
            );
            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaMovimento = [];

            foreach ($dt as $dr) {
                $movimento = new Movimento();

                $movimento->setId($dr["id"]);
                $movimento->setTipo($dr["tipo"]);
                $movimento->setDia($dr["dia"]);
                $movimento->setMes($dr["mes"]);
                $movimento->setAno($dr["ano"]);
                $movimento->setCat($dr["cat"]);
                $movimento->setDescricao($dr["descricao"]);
                $movimento->setValor($dr["valor"]);

                $listaMovimento[] = $movimento;
            }

            return $listaMovimento;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarTodos(int $cod, int $ano) {
        try {
            $sql = "SELECT * FROM financeiro_sorrident WHERE cod_usu = :cod AND ano= :ano ORDER BY id DESC";
            $param = array(
                ":cod" => $cod,
                ":ano" => $ano
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaMovimento = [];

            foreach ($dt as $dr) {
                $movimento = new Movimento();

                $movimento->setId($dr["id"]);
                $movimento->setTipo($dr["tipo"]);
                $movimento->setDia($dr["dia"]);
                $movimento->setMes($dr["mes"]);
                $movimento->setAno($dr["ano"]);
                $movimento->setCat($dr["cat"]);
                $movimento->setDescricao($dr["descricao"]);
                $movimento->setValor($dr["valor"]);

                $listaMovimento[] = $movimento;
            }

            return $listaMovimento;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

}

?>