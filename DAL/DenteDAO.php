<?php

require_once("Banco.php");

class DenteDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(Dente $dente) {
        try {

            $sql = "INSERT INTO `dentes` (nome,descricao, quadrante, imagem) VALUES (:nome, :descricao, :quadrante, :imagem)";
            $param = array(
                ":nome" => $dente->getNome(),
                ":descricao" => $dente->getDescricao(),
                ":quadrante" => $dente->getQuadrante(),
                ":imagem" => $dente->getImagem()
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

            $sql = "DELETE FROM `dentes` WHERE cod = :coddeletar";

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

    public function RetornarDentes() {
        try {

            $sql = "SELECT * FROM dentes ORDER BY cod ASC";


            $dataTable = $this->pdo->ExecuteQuery($sql);

            $listaDentes = [];

            foreach ($dataTable as $resultado) {
                $dente = new Dente();

                $dente->setCod($resultado["cod"]);
                $dente->setNome($resultado["nome"]);
                $dente->setDescricao($resultado["descricao"]);
                $dente->setQuadrante($resultado["quadrante"]);
                $dente->setImagem($resultado["imagem"]);


                $listaDentes[] = $dente;
            }

            return $listaDentes;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarDentes2(int $id) {
        try {

            $sql = "SELECT * FROM dentes WHERE cod = :cod ORDER BY cod ASC";
            $param = array(
                ":cod" => $id
            );

            $dataTable = $this->pdo->ExecuteQuery($sql, $param);

              $listaDentes = [];


            foreach ($dataTable as $resultado) {
                $dente = new Dente();

                $dente->setCod($resultado["cod"]);
                $dente->setNome($resultado["nome"]);
                $dente->setDescricao($resultado["descricao"]);
                $dente->setQuadrante($resultado["quadrante"]);
                $dente->setImagem($resultado["imagem"]);


                $listaDentes[] = $dente;
            }

            return $listaDentes;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }
    
      public function RetornarDentesQ(int $q) {
        try {

            $sql = "SELECT * FROM dentes WHERE quadrante = :q ORDER BY cod ASC";
            $param = array(
                ":q" => $q
            );

            $dataTable = $this->pdo->ExecuteQuery($sql, $param);

              $listaDentes = [];


            foreach ($dataTable as $resultado) {
                $dente = new Dente();

                $dente->setCod($resultado["cod"]);
                $dente->setNome($resultado["nome"]);
                $dente->setDescricao($resultado["descricao"]);
                $dente->setQuadrante($resultado["quadrante"]);
                $dente->setImagem($resultado["imagem"]);


                $listaDentes[] = $dente;
            }

            return $listaDentes;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function Alterar(Dente $dente) {
        try {
            $sql = "UPDATE dentes SET nome = :nome, descricao = :descricao, quadrante=:quadrante WHERE cod= :cod";
            $param = array(
                ":cod" => $dente->getCod(),
                ":nome" => $dente->getNome(),
                ":descricao" => $dente->getDescricao(),
                ":quadrante" => $dente->getQuadrante()
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































