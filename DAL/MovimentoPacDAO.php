<?php

require_once("Banco.php");

class MovimentoPacDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(MovimentoPac $movimentopac) {
        try {
            $sql = "INSERT financeiro_pac (cod_orcamento, tipo, subtotal, total, descricao, numparcelas, tipopag, categoria, dia, mes, ano) VALUES (:cod_orcamento, :tipo, :subtotal, :total, :descricao, :numparcelas, :tipopag, :categoria, :dia, :mes, :ano)";

            $param = array(
                ":cod_orcamento" => $movimentopac->getCod_orcamento(),
                ":tipo" => $movimentopac->getTipo(),
                ":subtotal" => $movimentopac->getSubtotal(),
                ":total" => $movimentopac->getTotal(),
                ":descricao" => $movimentopac->getDescricao(),
                ":numparcelas" => $movimentopac->getNumparcelas(),
                ":tipopag" => $movimentopac->getTipopag(),
                ":categoria" => $movimentopac->getCategoria(),
                ":dia" => $movimentopac->getDia(),
                ":mes" => $movimentopac->getMes(),
                ":ano" => $movimentopac->getAno()
            );
            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

    public function RetornarMes(int $mes, int $ano) {
        try {
            $sql = "SELECT * FROM financeiro_pac WHERE cod_orcamento!=0 AND mes= :mes AND ano=:ano ORDER BY cod ASC";
            $param = array(
                ":mes" => $mes,
                ":ano" => $ano
            );
            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaMovimentoPac = [];

            foreach ($dt as $dr) {
                $movimentopac = new MovimentoPac();

                $movimentopac->setCod($dr["cod"]);
                $movimentopac->setCod_orcamento($dr["cod_orcamento"]);
                $movimentopac->setTipo($dr["tipo"]);
                $movimentopac->setSubtotal($dr["subtotal"]);
                $movimentopac->setTotal($dr["total"]);
                $movimentopac->setDescricao($dr["descricao"]);
                $movimentopac->setNumparcelas($dr["numparcelas"]);
                $movimentopac->setTipopag($dr["tipopag"]);
                $movimentopac->setCategoria($dr["categoria"]);
                $movimentopac->setDia($dr["dia"]);
                $movimentopac->setMes($dr["mes"]);
                $movimentopac->setAno($dr["ano"]);

                $listaMovimentoPac[] = $movimentopac;
            }

            return $listaMovimentoPac;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarMesAP(int $ativopassivo, int $mes, int $ano) {
        try {
            $sql = "";
            $param = [];
            switch ($ativopassivo) {
                case 1:

                    $sql = "SELECT * FROM financeiro_pac WHERE cod_orcamento != 0 AND tipo = 1 AND mes= :mes AND ano=:ano  ORDER BY cod ASC";
                    $param = array(
                        ":mes" => $mes,
                        ":ano" => $ano
                    );
                    break;
                case 2:
                    $sql = "SELECT * FROM financeiro_pac WHERE cod_orcamento != 0 AND tipo = 2 AND mes= :mes AND ano=:ano ORDER BY cod ASC";
                    $param = array(
                        ":mes" => $mes,
                        ":ano" => $ano
                    );
                    break;
            }

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaMovimentoPac = [];

            foreach ($dt as $dr) {
                $movimentopac = new MovimentoPac();

                $movimentopac->setCod($dr["cod"]);
                $movimentopac->setCod_orcamento($dr["cod_orcamento"]);
                $movimentopac->setTipo($dr["tipo"]);
                $movimentopac->setSubtotal($dr["subtotal"]);
                $movimentopac->setTotal($dr["total"]);
                $movimentopac->setDescricao($dr["descricao"]);
                $movimentopac->setNumparcelas($dr["numparcelas"]);
                $movimentopac->setTipopag($dr["tipopag"]);
                $movimentopac->setCategoria($dr["categoria"]);
                $movimentopac->setDia($dr["dia"]);
                $movimentopac->setMes($dr["mes"]);
                $movimentopac->setAno($dr["ano"]);

                $listaMovimentoPac[] = $movimentopac;
            }

            return $listaMovimentoPac;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarAno(int $ano) {
        try {
            $sql = "SELECT * FROM financeiro_pac WHERE cod_orcamento!=0 AND ano=:ano ORDER BY cod ASC";
            $param = array(
                ":ano" => $ano
            );
            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaMovimentoPac = [];

            foreach ($dt as $dr) {
                $movimentopac = new MovimentoPac();

                $movimentopac->setCod($dr["cod"]);
                $movimentopac->setCod_orcamento($dr["cod_orcamento"]);
                $movimentopac->setTipo($dr["tipo"]);
                $movimentopac->setSubtotal($dr["subtotal"]);
                $movimentopac->setTotal($dr["total"]);
                $movimentopac->setDescricao($dr["descricao"]);
                $movimentopac->setNumparcelas($dr["numparcelas"]);
                $movimentopac->setTipopag($dr["tipopag"]);
                $movimentopac->setCategoria($dr["categoria"]);
                $movimentopac->setDia($dr["dia"]);
                $movimentopac->setMes($dr["mes"]);
                $movimentopac->setAno($dr["ano"]);

                $listaMovimentoPac[] = $movimentopac;
            }

            return $listaMovimentoPac;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarPac(int $cod, int $tipo) {
        try {
            $sql = "SELECT * FROM financeiro_pac WHERE cod_orcamento=:cod AND tipo = :tipo ORDER BY cod ASC";
            $param = array(
                ":cod" => $cod,
                ":tipo" => $tipo
            );
            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaMovimentoPac = [];

            foreach ($dt as $dr) {
                $movimentopac = new MovimentoPac();

                $movimentopac->setCod($dr["cod"]);
                $movimentopac->setCod_orcamento($dr["cod_orcamento"]);
                $movimentopac->setTipo($dr["tipo"]);
                $movimentopac->setSubtotal($dr["subtotal"]);
                $movimentopac->setTotal($dr["total"]);
                $movimentopac->setDescricao($dr["descricao"]);
                $movimentopac->setNumparcelas($dr["numparcelas"]);
                $movimentopac->setTipopag($dr["tipopag"]);
                $movimentopac->setCategoria($dr["categoria"]);
                $movimentopac->setDia($dr["dia"]);
                $movimentopac->setMes($dr["mes"]);
                $movimentopac->setAno($dr["ano"]);

                $listaMovimentoPac[] = $movimentopac;
            }

            return $listaMovimentoPac;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarMovimentoPacMesCat(int $mes, int $ano) {
        try {

            $sql = "SELECT * FROM financeiro_pac WHERE mes= :mes AND ano=:ano AND cod_orcamento = 0 ORDER BY cod ASC";
            $param = array(
                ":mes" => $mes,
                ":ano" => $ano
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaMovimentoPac = [];

            foreach ($dt as $dr) {
                $movimentopac = new MovimentoPac();

                $movimentopac->setCod($dr["cod"]);
                $movimentopac->setCod_orcamento($dr["cod_orcamento"]);
                $movimentopac->setTipo($dr["tipo"]);
                $movimentopac->setSubtotal($dr["subtotal"]);
                $movimentopac->setTotal($dr["total"]);
                $movimentopac->setDescricao($dr["descricao"]);
                $movimentopac->setNumparcelas($dr["numparcelas"]);
                $movimentopac->setTipopag($dr["tipopag"]);
                $movimentopac->setCategoria($dr["categoria"]);
                $movimentopac->setDia($dr["dia"]);
                $movimentopac->setMes($dr["mes"]);
                $movimentopac->setAno($dr["ano"]);

                $listaMovimentoPac[] = $movimentopac;
            }

            return $listaMovimentoPac;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarMovimentoCob(int $mes, int $ano) {
        try {

            $sql = "SELECT * FROM `financeiro_pac` WHERE `cod_orcamento` = 0 AND mes = $mes AND ano = $ano";

            $dt = $this->pdo->ExecuteQuery($sql);
            $listaMovimentoPac = [];

            foreach ($dt as $dr) {
                $movimentopac = new MovimentoPac();

                $movimentopac->setCod($dr["cod"]);
                $movimentopac->setCod_orcamento($dr["cod_orcamento"]);
                $movimentopac->setTipo($dr["tipo"]);
                $movimentopac->setSubtotal($dr["subtotal"]);
                $movimentopac->setTotal($dr["total"]);
                $movimentopac->setDescricao($dr["descricao"]);
                $movimentopac->setNumparcelas($dr["numparcelas"]);
                $movimentopac->setTipopag($dr["tipopag"]);
                $movimentopac->setCategoria($dr["categoria"]);
                $movimentopac->setDia($dr["dia"]);
                $movimentopac->setMes($dr["mes"]);
                $movimentopac->setAno($dr["ano"]);

                $listaMovimentoPac[] = $movimentopac;
            }

            return $listaMovimentoPac;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function Pagar(int $tipo, int $cod) {
        $sql = "UPDATE financeiro_pac SET tipo = :tipo WHERE cod = :cod";
        $param = array(
            ":tipo" => $tipo,
            ":cod" => $cod
        );
        return $this->pdo->ExecuteNonQuery($sql, $param);
    }

    public function RetornarAtraso(int $cod) {
        try {
            $sql = "SELECT * FROM financeiro_pac WHERE cod_orcamento = :cod AND tipo = 2 ORDER BY COD ASC LIMIT 1";
            $param = array(
                ":cod" => $cod
            );
            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaMovimentoPac = [];

            foreach ($dt as $dr) {
                $movimentopac = new MovimentoPac();

                $movimentopac->setCod($dr["cod"]);
                $movimentopac->setCod_orcamento($dr["cod_orcamento"]);
                $movimentopac->setTipo($dr["tipo"]);
                $movimentopac->setSubtotal($dr["subtotal"]);
                $movimentopac->setTotal($dr["total"]);
                $movimentopac->setDescricao($dr["descricao"]);
                $movimentopac->setNumparcelas($dr["numparcelas"]);
                $movimentopac->setTipopag($dr["tipopag"]);
                $movimentopac->setCategoria($dr["categoria"]);
                $movimentopac->setDia($dr["dia"]);
                $movimentopac->setMes($dr["mes"]);
                $movimentopac->setAno($dr["ano"]);

                $listaMovimentoPac[] = $movimentopac;
            }

            return $listaMovimentoPac;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarUltPag(int $cod) {
        try {
            $sql = "SELECT * FROM financeiro_pac WHERE cod_orcamento = :cod AND tipo = 1 ORDER BY COD DESC LIMIT 1";
            $param = array(
                ":cod" => $cod
            );
            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaMovimentoPac = [];

            foreach ($dt as $dr) {
                $movimentopac = new MovimentoPac();

                $movimentopac->setCod($dr["cod"]);
                $movimentopac->setCod_orcamento($dr["cod_orcamento"]);
                $movimentopac->setTipo($dr["tipo"]);
                $movimentopac->setSubtotal($dr["subtotal"]);
                $movimentopac->setTotal($dr["total"]);
                $movimentopac->setDescricao($dr["descricao"]);
                $movimentopac->setNumparcelas($dr["numparcelas"]);
                $movimentopac->setTipopag($dr["tipopag"]);
                $movimentopac->setCategoria($dr["categoria"]);
                $movimentopac->setDia($dr["dia"]);
                $movimentopac->setMes($dr["mes"]);
                $movimentopac->setAno($dr["ano"]);

                $listaMovimentoPac[] = $movimentopac;
            }

            return $listaMovimentoPac;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function DeletarPagamentos(int $coddeletar) {
        try {

            $sql = "DELETE FROM `financeiro_pac` WHERE cod_orcamento = :coddeletar AND tipo =2";

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

    public function RetornarCobranca(int $cod) {
        try {
            $sql = "SELECT * FROM financeiro_pac WHERE cod=:cod ORDER BY cod ASC";
            $param = array(
                ":cod" => $cod
            );
            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaMovimentoPac = [];

            foreach ($dt as $dr) {
                $movimentopac = new MovimentoPac();

                $movimentopac->setCod($dr["cod"]);
                $movimentopac->setCod_orcamento($dr["cod_orcamento"]);
                $movimentopac->setTipo($dr["tipo"]);
                $movimentopac->setSubtotal($dr["subtotal"]);
                $movimentopac->setTotal($dr["total"]);
                $movimentopac->setDescricao($dr["descricao"]);
                $movimentopac->setNumparcelas($dr["numparcelas"]);
                $movimentopac->setTipopag($dr["tipopag"]);
                $movimentopac->setCategoria($dr["categoria"]);
                $movimentopac->setDia($dr["dia"]);
                $movimentopac->setMes($dr["mes"]);
                $movimentopac->setAno($dr["ano"]);

                $listaMovimentoPac[] = $movimentopac;
            }

            return $listaMovimentoPac;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

}

?>