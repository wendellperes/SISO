<?php

require_once("Banco.php");

class PacienteDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(Paciente $paciente) {
        try {

            $sql = "INSERT INTO `paciente` (nome, nascimento, rg, cpf, endereco, numero, complemento, celular, residencial, responsavel, indicacao, data, status, dr) VALUES (:nome, :nascimento, :rg, :cpf, :endereco, :numero, :complemento, :celular, :residencial, :responsavel, :indicacao, :data, :status, :dr)";
            $param = array(
                ":nome" => $paciente->getNome(),
                ":nascimento" => $paciente->getNascimento(),
                ":rg" => $paciente->getRg(),
                ":cpf" => $paciente->getCpf(),
                ":endereco" => $paciente->getEndereco(),
                ":numero" => $paciente->getNumero(),
                ":complemento" => $paciente->getComplemento(),
                ":celular" => $paciente->getCelular(),
                ":residencial" => $paciente->getResidencial(),
                ":responsavel" => $paciente->getResponsavel(),
                ":indicacao" => $paciente->getIndicacao(),
                ":data" => $paciente->getData(),
                ":status" => $paciente->getStatus(),
                ":dr" => $paciente->getDr()
            );

            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

    public function RetornarPacientes(string $termo, int $tipo, int $status) {
        try {
            
            $sql = "";
            $param = [];
            switch ($tipo) {
                case 1:
                    $sql = "SELECT * FROM paciente WHERE nome LIKE :termo ORDER BY id DESC";
                    $param = array(
                        ":termo" => "%{$termo}%"
                    );
                    break;
                case 2:
                    $sql = "SELECT * FROM paciente WHERE id = :id ORDER BY data DESC";
                    $param = array(
                        ":id" => $status
                    );
                    break;
                case 3:
                    $sql = "SELECT * FROM paciente WHERE nome LIKE :termo AND status= :status ORDER BY nome ASC";
                    $param = array(
                        ":termo" => "%{$termo}%",
                        ":status" => $status
                    );
                    break;
                case 4:
                    $sql = "SELECT * FROM paciente WHERE nome LIKE :termo ORDER BY id DESC LIMIT 5";
                    $param = array(
                        ":termo" => "%{$termo}%"
                    );
                    break;
            }



            $dataTable = $this->pdo->ExecuteQuery($sql, $param);

            $listaPacientes = [];

            foreach ($dataTable as $resultado) {
                $paciente = new Paciente();

                $paciente->setId($resultado["id"]);
                $paciente->setNome($resultado["nome"]);
                $paciente->setNascimento($resultado["nascimento"]);
                $paciente->setRg($resultado["rg"]);
                $paciente->setCpf($resultado["cpf"]);
                $paciente->setEndereco($resultado["endereco"]);
                $paciente->setNumero($resultado["numero"]);
                $paciente->setComplemento($resultado["complemento"]);
                $paciente->setCelular($resultado["celular"]);
                $paciente->setResidencial($resultado["residencial"]);
                $paciente->setResponsavel($resultado["responsavel"]);
                $paciente->setIndicacao($resultado["indicacao"]);
                $paciente->setData($resultado["data"]);
                $paciente->setStatus($resultado["status"]);
                $paciente->setDr($resultado["dr"]);

                $listaPacientes[] = $paciente;
            }

            return $listaPacientes;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarAtivosInativos(int $tipo) {
        try {
            $sql = "";
            switch ($tipo) {
                case 1:
                    $sql = "SELECT * FROM paciente";
                    break;
                case 2:
                    $sql = "SELECT * FROM paciente WHERE status = 1";

                    break;
                case 3:
                    $sql = "SELECT * FROM paciente WHERE status = 2";

                    break;
            }



            $dataTable = $this->pdo->ExecuteQuery($sql);

            $listaPacientes = [];

            foreach ($dataTable as $resultado) {
                $paciente = new Paciente();

                $paciente->setId($resultado["id"]);
                $paciente->setNome($resultado["nome"]);
                $paciente->setNascimento($resultado["nascimento"]);
                $paciente->setRg($resultado["rg"]);
                $paciente->setCpf($resultado["cpf"]);
                $paciente->setEndereco($resultado["endereco"]);
                $paciente->setNumero($resultado["numero"]);
                $paciente->setComplemento($resultado["complemento"]);
                $paciente->setCelular($resultado["celular"]);
                $paciente->setResidencial($resultado["residencial"]);
                $paciente->setResponsavel($resultado["responsavel"]);
                $paciente->setIndicacao($resultado["indicacao"]);
                $paciente->setData($resultado["data"]);
                $paciente->setStatus($resultado["status"]);
                $paciente->setDr($resultado["dr"]);

                $listaPacientes[] = $paciente;
            }

            return $listaPacientes;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function VerificaCPFExiste(string $cpf) {
        try {
            $sql = "SELECT cpf FROM paciente WHERE cpf = :cpf";

            $param = array(
                ":cpf" => $cpf
            );

            $dr = $this->pdo->ExecuteQueryOneRow($sql, $param);

            if (!empty($dr)) {
                return 1;
            } else {
                return -1;
            }
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function Alterar(Paciente $paciente) {
        try {
            $sql = "UPDATE paciente SET nome = :nome, nascimento = :nascimento, rg =:rg, cpf= :cpf, endereco = :endereco, numero= :numero, complemento= :complemento, celular= :celular, residencial= :residencial, responsavel =:responsavel, indicacao= :indicacao, status= :status, dr= :dr WHERE id= :id";
            $param = array(
                ":id" => $paciente->getId(),
                ":nome" => $paciente->getNome(),
                ":nascimento" => $paciente->getNascimento(),
                ":rg" => $paciente->getRg(),
                ":cpf" => $paciente->getCpf(),
                ":endereco" => $paciente->getEndereco(),
                ":numero" => $paciente->getNumero(),
                ":complemento" => $paciente->getComplemento(),
                ":celular" => $paciente->getCelular(),
                ":residencial" => $paciente->getResidencial(),
                ":responsavel" => $paciente->getResponsavel(),
                ":indicacao" => $paciente->getIndicacao(),
                ":status" => $paciente->getStatus(),
                ":dr" => $paciente->getDr()
            );

            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

    public function RetornarUltimoPaciente() {
        try {
            $sql = "SELECT * FROM paciente ORDER BY ID DESC LIMIT 1";

            $dataTable = $this->pdo->ExecuteQuery($sql);

            $cod_paciente = 0;
            $cod = 0;
            foreach ($dataTable as $resultado) {
               
                $cod = $resultado["id"];

                $cod_paciente = $cod;
            }

            return $cod_paciente;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function RetornarNomePac(int $id) {
        try {

            $sql = "SELECT * FROM paciente WHERE id = :cod  ORDER BY id ASC";
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
    
        public function AlterarIna(int $status, int $cod) {
        $sql = "UPDATE paciente SET status = :status WHERE id = :cod";
        $param = array(
            ":status" => $status,
            ":cod" => $cod
        );
        return $this->pdo->ExecuteNonQuery($sql, $param);
    } 
}
