<?php

require_once("Banco.php");

class PagParProDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(PagParPro $pagparpro) {
        try {
            $sql = "INSERT pag_par_pro (descricao, valor, financeiro_pac, tipopag, dia, mes, ano, esp_proc) VALUES (:descricao, :valor, :financeiro_pac, :tipopag, :dia, :mes, :ano, :esp_proc)";

            $param = array(
                ":descricao" => $pagparpro->getDescricao(),
                ":valor" => $pagparpro->getValor(),
                ":financeiro_pac" => $pagparpro->getFinanceiro_pac(),
                ":tipopag" => $pagparpro->getTipopag(),
                ":dia" => $pagparpro->getDia(),
                ":mes" => $pagparpro->getMes(),
                ":ano" => $pagparpro->getAno(),
                ":esp_proc" => $pagparpro->getEsp_pro()
            );



            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

    public function RetornarTodos(int $cod) {
        try {
            $sql = "SELECT * FROM pag_par_pro WHERE financeiro_pac = :cod AND esp_proc != 0  ORDER BY cod ASC";
            $param = array(
                ":cod" => $cod
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listapagparpro = [];

            foreach ($dt as $dr) {
                $pagparpro = new PagParPro();

                $pagparpro->setDescricao($dr["descricao"]);
                $pagparpro->setValor($dr["valor"]);
                $pagparpro->setFinanceiro_pac($dr["financeiro_pac"]);
                $pagparpro->setTipopag($dr["tipopag"]);
                $pagparpro->setDia($dr["dia"]);
                $pagparpro->setMes($dr["mes"]);
                $pagparpro->setAno($dr["ano"]);



                $listapagparpro[] = $pagparpro;
            }

            return $listapagparpro;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }
       public function RetornarM(int $cod) {
        try {
            $sql = "SELECT * FROM pag_par_pro WHERE financeiro_pac = :cod AND esp_proc = 0  ORDER BY cod ASC";
            $param = array(
                ":cod" => $cod
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listapagparpro = [];

            foreach ($dt as $dr) {
                $pagparpro = new PagParPro();

                $pagparpro->setDescricao($dr["descricao"]);
                $pagparpro->setValor($dr["valor"]);
                $pagparpro->setFinanceiro_pac($dr["financeiro_pac"]);
                $pagparpro->setTipopag($dr["tipopag"]);
                $pagparpro->setDia($dr["dia"]);
                $pagparpro->setMes($dr["mes"]);
                $pagparpro->setAno($dr["ano"]);



                $listapagparpro[] = $pagparpro;
            }

            return $listapagparpro;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarMes(int $cod, int $mes, int $ano) {
        try {
            $sql = "SELECT * FROM pag_par_pro WHERE financeiro_pac = :cod AND mes= :mes AND ano=:ano ORDER BY cod DESC";
            $param = array(
                ":cod" => $cod,
                ":mes" => $mes,
                ":ano" => $ano
            );
            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listapagparpro = [];

            foreach ($dt as $dr) {
                $pagparpro = new PagParPro();

                $pagparpro->setDescricao($dr["descricao"]);
                $pagparpro->setValor($dr["valor"]);
                $pagparpro->setFinanceiro_pac($dr["financeiro_pac"]);
                $pagparpro->setDia($dr["dia"]);
                $pagparpro->setMes($dr["mes"]);
                $pagparpro->setAno($dr["ano"]);



                $listapagparpro[] = $pagparpro;
            }

            return $listapagparpro;
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

}

?>