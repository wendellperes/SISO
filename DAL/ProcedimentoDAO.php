<?php

require_once("Banco.php");

class ProcedimentoDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(Procedimento $procedimento) {
        try {

            $sql = "INSERT INTO `procedimentos` (dente, servico, usuario, valor, status, nivel, obs, tipo, dia, mes, ano, categoria) VALUES (:dente, :servico, :usuario, :valor, :status, :nivel, :obs, :tipo, :dia, :mes, :ano, :categoria)";
            $param = array(
                ":dente" => $procedimento->getDente(),
                ":servico" => $procedimento->getServico(),
                ":usuario" => $procedimento->getUsuario(),
                ":valor" => $procedimento->getValor(),
                ":status" => $procedimento->getStatus(),
                ":nivel" => $procedimento->getNivel(),
                ":obs" => $procedimento->getObs(),
                ":tipo" => $procedimento->getTipo(),
                ":dia" => $procedimento->getDia(),
                ":mes" => $procedimento->getMes(),
                ":ano" => $procedimento->getAno(),
                ":categoria" => $procedimento->getCategoria(),
            );

            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

    public function RetornarProcedimentos(string $termo, int $tipo, int $status) {
        try {
            $sql = "";
            $param = [];
            switch ($tipo) {
                case 1:
                    $sql = "SELECT * FROM procedimentos WHERE usuario= :orcamento ORDER BY nivel DESC";
                    $param = array(
                        ":orcamento" => $status
                    );
                    break;
                case 2:
                    $sql = "SELECT * FROM dentes WHERE id = :id ORDER BY data DESC";
                    $param = array(
                        ":id" => $status
                    );
                    break;
            }



            $dataTable = $this->pdo->ExecuteQuery($sql, $param);

            $listaProcedimentos = [];

            foreach ($dataTable as $resultado) {
                $procedimento = new Procedimento();

                $procedimento->setCod($resultado["cod"]);
                $procedimento->setDente($resultado["dente"]);
                $procedimento->setServico($resultado["servico"]);
                $procedimento->setUsuario($resultado["usuario"]);
                $procedimento->setValor($resultado["valor"]);
                $procedimento->setStatus($resultado["status"]);
                $procedimento->setNivel($resultado["nivel"]);
                $procedimento->setObs($resultado["obs"]);
                $procedimento->setTipo($resultado["tipo"]);
                $procedimento->setDia($resultado["dia"]);
                $procedimento->setMes($resultado["mes"]);
                $procedimento->setAno($resultado["ano"]);
                $procedimento->setCategoria($resultado["categoria"]);


                $listaProcedimentos[] = $procedimento;
            }

            return $listaProcedimentos;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function Alterar(Procedimento $procedimento) {
        try {
            $sql = "UPDATE procedimentos SET dente = :dente, servico = :servico, usuario=:usuario, valor= :valor, status = :status, nivel = :nivel, obs= :obs, tipo= :tipo, data = :data, categoria= :categoria  WHERE cod= :cod";
            $param = array(
                ":cod" => $procedimento->getCod(),
                ":dente" => $procedimento->getDente(),
                ":servico" => $procedimento->getServico(),
                ":usuario" => $procedimento->getUsuario(),
                ":valor" => $procedimento->getValor(),
                ":status" => $procedimento->getStatus(),
                ":nivel" => $procedimento->getNivel(),
                ":obs" => $procedimento->getObs(),
                ":tipo" => $procedimento->getTipo(),
                ":data" => $procedimento->getData(),
                ":categoria" => $procedimento->getCategoria()
            );

            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

    public function Deletar2(int $coddeletar) {
        try {

            $sql = "DELETE FROM `procedimentos` WHERE cod = :coddeletar";

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

    
     public function DeletarO(int $coddeletar) {
        try {

            $sql = "DELETE FROM `procedimentos` WHERE usuario = :coddeletar";

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
    public function AlterStatusTodos2(int $status, int $id) {
        $sql = "UPDATE procedimentos SET status = :nvStatus WHERE cod = :id";
        $param = array(
            ":nvStatus" => $status,
            ":id" => $id
        );
        return $this->pdo->ExecuteNonQuery($sql, $param);
    }
    
      public function RetornarProcedimentosMesCat(int $categoria, int $mes, int $ano) {
        try {

            $sql = "SELECT * FROM procedimentos WHERE mes= :mes AND ano=:ano AND categoria = :categoria  ORDER BY cod ASC";
            $param = array(
                ":categoria" => $categoria,
                ":mes" => $mes,
                ":ano" => $ano
            );

            $dataTable = $this->pdo->ExecuteQuery($sql, $param);

            $listaProcedimentos = [];

            foreach ($dataTable as $resultado) {
                $procedimento = new Procedimento();

                $procedimento->setCod($resultado["cod"]);
                $procedimento->setDente($resultado["dente"]);
                $procedimento->setServico($resultado["servico"]);
                $procedimento->setUsuario($resultado["usuario"]);
                $procedimento->setValor($resultado["valor"]);
                $procedimento->setStatus($resultado["status"]);
                $procedimento->setNivel($resultado["nivel"]);
                $procedimento->setObs($resultado["obs"]);
                $procedimento->setTipo($resultado["tipo"]);
                $procedimento->setDia($resultado["dia"]);
                $procedimento->setMes($resultado["mes"]);
                $procedimento->setAno($resultado["ano"]);
                $procedimento->setCategoria($resultado["categoria"]);


                $listaProcedimentos[] = $procedimento;
            }

            return $listaProcedimentos;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

}






























