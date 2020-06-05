<?php

require_once("Banco.php");

class AnamneseDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(Anamnese $anamnese) {
        try {

            $sql = "INSERT INTO `anamnese` (cod_usu, dentista_antes, reacao_anestesia, como, alergia_medicamento, qual, outras_alergias, doencas, outra_doenca, doenca_familia, medicamento, data) VALUES (:cod_usu, :dentista_antes, :reacao_anestesia, :como, :alergia_medicamento, :qual, :outras_alergias, :doencas, :outra_doenca, :doenca_familia, :medicamento, :data)";
            $param = array(
                ":cod_usu" => $anamnese->getCod_usu(),
                ":dentista_antes" => $anamnese->getDentista_antes(),
                ":reacao_anestesia" => $anamnese->getReacao_anestesia(),
                ":como" => $anamnese->getComo(),
                ":alergia_medicamento" => $anamnese->getAlergia_medicamento(),
                ":qual" => $anamnese->getQual(),
                ":outras_alergias" => $anamnese->getOutras_alergia(),
                ":doencas" => $anamnese->getDoencas(),
                ":outra_doenca" => $anamnese->getOutra_doenca(),
                ":doenca_familia" => $anamnese->getDoenca_familia(),
                ":medicamento" => $anamnese->getMedicamento(),
                ":data" => $anamnese->getData()
            );

            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

    public function RetornarAnamnese(string $termo, int $cod_usu2, int $tipo) {
        try {
            $sql = "";
            $param = [];
            switch ($tipo) {
                case 1:
                    $sql = "SELECT * FROM anamnese WHERE cod_usu = :cod_usu2 ORDER BY cod DESC LIMIT 1";
                    $param = array(
                        ":cod_usu2" => $cod_usu2
                    );
                    break;
                case 2:
                    $sql = "SELECT * FROM paciente WHERE id = :id ORDER BY data DESC";
                    $param = array(
                        ":id" => $status
                    );
                    break;
            }



            $dataTable = $this->pdo->ExecuteQuery($sql, $param);

            $ListaAnamnese = [];

            foreach ($dataTable as $resultado) {
                $anamnese = new Anamnese();

                $anamnese->setCod($resultado["cod"]);
                $anamnese->setCod_usu($resultado["cod_usu"]);
                $anamnese->setDentista_antes($resultado["dentista_antes"]);
                $anamnese->setReacao_anestesia($resultado["reacao_anestesia"]);
                $anamnese->setComo($resultado["como"]);
                $anamnese->setAlergia_medicamento($resultado["alergia_medicamento"]);
                $anamnese->setQual($resultado["qual"]);
                $anamnese->setOutras_alergia($resultado["outras_alergias"]);
                $anamnese->setDoencas($resultado["doencas"]);
                $anamnese->setOutra_doenca($resultado["outra_doenca"]);
                $anamnese->setDoenca_familia($resultado["doenca_familia"]);
                $anamnese->setMedicamento($resultado["medicamento"]);
                $anamnese->setData($resultado["data"]);
                $ListaAnamnese[] = $anamnese;
            }

            return $ListaAnamnese;
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
            $sql = "UPDATE paciente SET nome = :nome, nascimento = :nascimento, rg =:rg, cpf= :cpf, endereco = :endereco, numero= :numero, complemento= :complemento, celular= :celular, residencial= :residencial, responsavel =:responsavel, indicacao= :indicacao, status= :status WHERE id= :id";
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
                ":status" => $paciente->getStatus()
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































