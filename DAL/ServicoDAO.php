<?php

require_once("Banco.php");

class ServicoDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(Servico $servico) {
        try {

            $sql = "INSERT INTO `servicos` (nome,descricao, categoria, valor) VALUES (:nome, :descricao, :categoria, :valor)";
            $param = array(
                ":nome" => $servico->getNome(),
                ":descricao" => $servico->getDescricao(),
                ":categoria" => $servico->getCategoria(),
                ":valor" => $servico->getValor()
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

            $sql = "DELETE FROM `servicos` WHERE cod = :coddeletar";

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

    public function RetornarServicos() {
        try {

            $sql = "SELECT * FROM servicos ORDER BY cod ASC";


            $dataTable = $this->pdo->ExecuteQuery($sql);

            $listaServicos = [];

            foreach ($dataTable as $resultado) {
                $servico = new Servico();

                $servico->setCod($resultado["cod"]);
                $servico->setNome($resultado["nome"]);
                $servico->setDescricao($resultado["descricao"]);
                $servico->setCategoria($resultado["categoria"]);
                $servico->setValor($resultado["valor"]);

                $listaServicos[] = $servico;
            }

            return $listaServicos;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarServicos2(int $id) {
        try {

            $sql = "SELECT * FROM servicos WHERE cod = :cod  ORDER BY cod ASC";
            $param = array(
                ":cod" => $id
            );

            $dataTable = $this->pdo->ExecuteQuery($sql, $param);

            $listaServicos = [];

            foreach ($dataTable as $resultado) {
                $servico = new Servico();

                $servico->setCod($resultado["cod"]);
                $servico->setNome($resultado["nome"]);
                $servico->setDescricao($resultado["descricao"]);
                $servico->setCategoria($resultado["categoria"]);
                $servico->setValor($resultado["valor"]);

                $listaServicos[] = $servico;
            }

            return $listaServicos;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

     public function RetornarServicosPorCat(int $cat, string $termo) {
        try {

            $sql = "SELECT * FROM servicos WHERE categoria = :cat AND nome LIKE :termo ORDER BY cod ASC";
            $param = array(
                ":cat" => $cat,
                ":termo" => "%{$termo}%"
            );

            $dataTable = $this->pdo->ExecuteQuery($sql, $param);

            $listaServicos = [];

            foreach ($dataTable as $resultado) {
                $servico = new Servico();

                $servico->setCod($resultado["cod"]);
                $servico->setNome($resultado["nome"]);
                $servico->setDescricao($resultado["descricao"]);
                $servico->setCategoria($resultado["categoria"]);
                $servico->setValor($resultado["valor"]);

                $listaServicos[] = $servico;
            }

            return $listaServicos;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function Alterar(Servico $servico) {
        try {
            $sql = "UPDATE servicos SET nome = :nome, descricao = :descricao, categoria = :categoria, valor=:valor WHERE cod= :cod";
            $param = array(
                ":cod" => $servico->getCod(),
                ":nome" => $servico->getNome(),
                ":descricao" => $servico->getDescricao(),
                ":categoria" => $servico->getCategoria(),
                ":valor" => $servico->getValor()
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































