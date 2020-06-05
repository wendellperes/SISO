<?php

require_once("Banco.php");

class PagamentoDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(Pagamento $pagamento) {
        try {

            $sql = "INSERT INTO `financeiro_pac` (cod_orcamento, tipo, subtotal, total, descricao, numparcelas, tipopag, dia, mes, ano) VALUES (:cod_orcamento, :tipo, :subtotal, :total, :descricao, :numparcelas, :tipopag, :dia, :mes, :ano)";
            $param = array(
                ":cod_orcamento" => $pagamento->getCod_orcamento(),
                ":tipo" => $pagamento->getTipo(),
                ":subtotal" => $pagamento->getSubtotal(),
                ":total" => $pagamento->getTotal(),
                ":descricao" => $pagamento->getDescricao(),
                ":tipopag" => $pagamento->getTipopag(),
                ":numparcelas" => $pagamento->getNumparcelas(),
                ":dia" => $pagamento->getDia(),
                ":mes" => $pagamento->getMes(),
                ":ano" => $pagamento->getAno()
            );

            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

    public function Deletar(int $coddeletar) {
        try {

            $sql = "DELETE FROM `financeiro_pac` WHERE cod = :coddeletar";

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

    public function RetornarPagamentos(int $id) {
        try {

            $sql = "SELECT * FROM financeiro_pac WHERE cod_orcamento = :cod ORDER BY cod ASC";
            $param = array(
                ":cod" => $id
            );

            $dataTable = $this->pdo->ExecuteQuery($sql, $param);

            $listaPagamentos = [];

            foreach ($dataTable as $resultado) {
                $pagamento = new Pagamento();

                $pagamento->setCod($resultado["cod"]);
                $pagamento->setCod_orcamento($resultado["cod_orcamento"]);
                $pagamento->setTipo($resultado["tipo"]);
                $pagamento->setSubtotal($resultado["subtotal"]);
                $pagamento->setTotal($resultado["total"]);
                $pagamento->setDescricao($resultado["descricao"]);
                $pagamento->setNumparcelas($resultado["numparcelas"]);
                $pagamento->setTipopag($resultado["tipopag"]);
                $pagamento->setDia($resultado["dia"]);
                $pagamento->setMes($resultado["mes"]);
                $pagamento->setAno($resultado["ano"]);

                $listaPagamentos[] = $pagamento;
            }

            return $listaPagamentos;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarPagamentos2(int $mes, int $ano, int $categoria) {
        try {

            $sql = "SELECT * FROM financeiro_pac WHERE mes = :mes, ano = :ano, categoria = :categoria ORDER BY cod ASC";
            $param = array(
                ":mes" => $mes,
                ":ano" => $ano,
                ":categoria" => $categoria
            );


            $dataTable = $this->pdo->ExecuteQuery($sql, $param);

            $listaPagamentos = [];

            foreach ($dataTable as $resultado) {
                $pagamento = new Pagamento();

                $pagamento->setCod($resultado["cod"]);
                $pagamento->setCod_orcamento($resultado["cod_orcamento"]);
                $pagamento->setTipo($resultado["tipo"]);
                $pagamento->setValor($resultado["valor"]);
                $pagamento->setDescricao($resultado["descricao"]);
                $pagamento->setNumparcelas($resultado["numparcelas"]);
                $pagamento->setCategoria($resultado["categoria"]);
                $pagamento->setDia($resultado["dia"]);
                $pagamento->setMes($resultado["mes"]);
                $pagamento->setAno($resultado["ano"]);

                $listaPagamentos[] = $pagamento;
            }

            return $listaPagamentos;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    

}































