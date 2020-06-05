<?php
require_once("Banco.php");

class ListaesperaDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(Listaespera $listaespera) {
        try {

            $sql = "INSERT INTO `listaespera` (cod_paciente, data) VALUES (:cod_paciente, :data)";
            $param = array(
                ":cod_paciente" => $listaespera->getCod_paciente(),
                ":data" => $listaespera->getData()
            );

            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

    public function DeletarEspera(int $coddeletar) {
        try {

            $sql = "DELETE FROM `listaespera` WHERE cod = :coddeletar";

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

    public function DeletarEvento(int $coddeletar) {
        try {

            $sql = "DELETE FROM `eventos` WHERE id = :coddeletar";

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

    public function RetornarListaespera() {
        try {

            $sql = "SELECT * FROM listaespera ORDER BY cod ASC";


            $dataTable = $this->pdo->ExecuteQuery($sql);

            $Llistaespera = [];

            foreach ($dataTable as $resultado) {
                $listaespera = new Listaespera();

                $listaespera->setCod($resultado["cod"]);
                $listaespera->setCod_paciente($resultado["cod_paciente"]);
                $listaespera->setData($resultado["data"]);


                $Llistaespera[] = $listaespera;
            }

            return $Llistaespera;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

}































