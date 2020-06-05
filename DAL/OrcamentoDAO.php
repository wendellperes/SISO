<?php

require_once("Banco.php");

class OrcamentoDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(Orcamento $orcamento) {
        try {

            $sql = "INSERT INTO `orcamento` (status,usuario, dia, mes, ano, func) VALUES (:status, :usuario, :dia, :mes, :ano, :func)";
            $param = array(
                ":status" => $orcamento->getStatus(),
                ":usuario" => $orcamento->getUsuario(),
                ":dia" => $orcamento->getDia(),
                ":mes" => $orcamento->getMes(),
                ":ano" => $orcamento->getAno(),
                ":func" => $orcamento->getFunc()
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

            $sql = "DELETE FROM `orcamento` WHERE cod = :coddeletar";

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

    public function RetornarOrcamentosConsulta(int $tipo, int $id, int $mes, int $ano) {
        try {

            $sql = "";
            $param = [];
            switch ($tipo) {
                case 1:
                    $sql = "SELECT * FROM orcamento WHERE usuario = :cod AND mes = :mes AND ano = :ano  ORDER BY cod ASC";
                    $param = array(
                        ":cod" => $id,
                        ":mes" => $mes,
                        ":ano" => $ano
                    );
                    break;
                case 2:
                    $sql = "SELECT * FROM orcamento WHERE cod = :cod AND mes = :mes AND ano = :ano  ORDER BY cod DESC";
                    $param = array(
                        ":cod" => $id,
                        ":mes" => $mes,
                        ":ano" => $ano
                    );
                    break;
            }



            $dataTable = $this->pdo->ExecuteQuery($sql, $param);

            $listaOrcamentos = [];

            foreach ($dataTable as $resultado) {
                $orcamento = new Orcamento();

                $orcamento->setCod($resultado["cod"]);
                $orcamento->setStatus($resultado["status"]);
                $orcamento->setUsuario($resultado["usuario"]);
                $orcamento->setDia($resultado["dia"]);
                $orcamento->setMes($resultado["mes"]);
                $orcamento->setAno($resultado["ano"]);
                $orcamento->setFunc($resultado["func"]);



                $listaOrcamentos[] = $orcamento;
            }

            return $listaOrcamentos;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarOrcamentos(int $tipo, int $id) {
        try {

            $sql = "";
            $param = [];
            switch ($tipo) {
                case 1:
                    $sql = "SELECT * FROM orcamento WHERE usuario = :cod  ORDER BY cod ASC";
                    $param = array(
                        ":cod" => $id
                    );
                    break;
                case 2:
                    $sql = "SELECT * FROM orcamento WHERE cod = :cod  ORDER BY cod DESC";
                    $param = array(
                        ":cod" => $id
                    );
                    break;
            }



            $dataTable = $this->pdo->ExecuteQuery($sql, $param);

            $listaOrcamentos = [];

            foreach ($dataTable as $resultado) {
                $orcamento = new Orcamento();

                $orcamento->setCod($resultado["cod"]);
                $orcamento->setStatus($resultado["status"]);
                $orcamento->setUsuario($resultado["usuario"]);
                $orcamento->setDia($resultado["dia"]);
                $orcamento->setMes($resultado["mes"]);
                $orcamento->setAno($resultado["ano"]);
                $orcamento->setFunc($resultado["func"]);



                $listaOrcamentos[] = $orcamento;
            }

            return $listaOrcamentos;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarUltimoOrcamento(int $func) {
        try {
            $sql = "SELECT * FROM orcamento WHERE status = 1 AND func = $func ORDER BY COD DESC LIMIT 1";

            $dataTable = $this->pdo->ExecuteQuery($sql);

            $listaOrcamentos = [];

            foreach ($dataTable as $resultado) {
                $orcamento = new Orcamento();

                $orcamento->setCod($resultado["cod"]);
                $orcamento->setStatus($resultado["status"]);
                $orcamento->setUsuario($resultado["usuario"]);
                $orcamento->setDia($resultado["dia"]);
                $orcamento->setMes($resultado["mes"]);
                $orcamento->setAno($resultado["ano"]);
                $orcamento->setFunc($resultado["func"]);



                $listaOrcamentos[] = $orcamento;
            }

            return $listaOrcamentos;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function Alterar(Orcamento $orcamento) {
        try {
            $sql = "UPDATE orcamento SET status = :status, usuario = :usuario, dia= :dia, mes = :mes, ano = :ano, func = :func WHERE cod= :cod";
            $param = array(
                ":cod" => $orcamento->getCod(),
                ":status" => $orcamento->getStatus(),
                ":usuario" => $orcamento->getUsuario(),
                ":dia" => $orcamento->getDia(),
                ":mes" => $orcamento->getMes(),
                ":ano" => $orcamento->getAno(),
                ":func" => $orcamento->getFunc(),
            );

            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

    public function AlterStatusTodos(int $status, int $id) {
        $sql = "UPDATE orcamento SET status = :nvStatus WHERE cod = :id";
        $param = array(
            ":nvStatus" => $status,
            ":id" => $id
        );
        return $this->pdo->ExecuteNonQuery($sql, $param);
    }

}
