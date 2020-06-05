<?php

require_once("Banco.php");

class UsuarioDAO {

    private $pdo;
    private $debug;

    public function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    } 

    public function Cadastrar(Usuario $usuario) {
        try {

            $sql = "INSERT INTO `usuarios` (nome, usuario, rg, cpf, email, foto, permissao, rua, bairro, numero, celular, senha) VALUES (:nome, :usuario, :rg, :cpf, :email, :foto, :permissao, :rua, :bairro, :numero, :celular, :senha)";
            $param = array(
                ":nome" => $usuario->getNome(),
                ":usuario" => $usuario->getUsuario(),
                ":rg" => $usuario->getRg(),
                ":cpf" => $usuario->getCpf(),
                ":email" => $usuario->getEmail(),
                ":foto" => $usuario->getFoto(),
                ":permissao" => $usuario->getPermissao(),
                ":rua" => $usuario->getRua(),
                ":bairro" => $usuario->getBairro(),
                ":numero" => $usuario->getNumero(),
                ":celular" => $usuario->getCelular(),
                ":senha" => $usuario->getSenha()
            );

            return $this->pdo->ExecuteNonQuery($sql, $param);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return false;
        }
    }

    public function RetornarUsuarios(string $termo, int $tipo, int $status) {
        try {
            $sql = "";
            $param = [];
            switch ($tipo) {
                case 1:
                    $sql = "SELECT * FROM usuarios WHERE nome LIKE :termo ORDER BY cod DESC";
                    $param = array(
                        ":termo" => "%{$termo}%"
                    );
                    break;
                case 2:
                    $sql = "SELECT * FROM usuarios WHERE cod = :cod ORDER BY cod DESC";
                    $param = array(
                        ":cod" => $status
                    );
                    break;
                case 3:
                    $sql = "SELECT * FROM usuarios WHERE nome LIKE :termo AND permissao= :permissao ORDER BY cod DESC";
                    $param = array(
                        ":termo" => "%{$termo}%",
                        ":permissao" => $status
                    );
                    break;
            }



            $dataTable = $this->pdo->ExecuteQuery($sql, $param);

            $listaUsuarios = [];

            foreach ($dataTable as $resultado) {
                $usuario = new Usuario();

                $usuario->setCod($resultado["cod"]);
                $usuario->setNome($resultado["nome"]);
                $usuario->setUsuario($resultado["usuario"]);
                $usuario->setRg(($resultado["rg"]));
                $usuario->setCpf(($resultado["cpf"]));
                $usuario->setEmail(($resultado["email"]));
                $usuario->setFoto($resultado["foto"]);
                $usuario->setPermissao($resultado["permissao"]);
                $usuario->setRua(($resultado["rua"]));
                $usuario->setBairro($resultado["bairro"]);
                $usuario->setNumero(($resultado["numero"]));
                $usuario->setCelular(($resultado["celular"]));
                $usuario->setSenha(($resultado["senha"]));

                $listaUsuarios[] = $usuario;
            }

            return $listaUsuarios;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }

    public function Alterar(Usuario $usuario) {
        try {
            $sql = "UPDATE usuarios SET nome = :nome, usuario = :usuario, rg =:rg, cpf= :cpf, email = :email, permissao = :permissao,  rua = :rua, bairro= :bairro, numero= :numero, celular= :celular, senha= :senha WHERE cod= :cod";
            $param = array(
                ":cod" => $usuario->getCod(),
                ":nome" => $usuario->getNome(),
                ":usuario" => $usuario->getUsuario(),
                ":rg" => $usuario->getRg(),
                ":cpf" => $usuario->getCpf(),
                ":email" => $usuario->getEmail(),
               // ":foto" => $usuario->getFoto(),
                ":permissao" => $usuario->getPermissao(),
                ":rua" => $usuario->getRua(),
                ":bairro" => $usuario->getBairro(),
                ":numero" => $usuario->getNumero(),
                ":celular" => $usuario->getCelular(),
                ":senha" => $usuario->getSenha()
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

            $sql = "DELETE FROM `usuarios` WHERE cod = :coddeletar";

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

     public function AutenticarUsuario(string $usu, string $senha, int $permissao) {
        try {
            if ($permissao == 2) {
                $sql = "SELECT cod, nome, permissao FROM usuarios WHERE permissao = :permissao AND usuario = :usuario AND senha = :senha";
                $param = array(
                    ":permissao" => $permissao,
                    ":usuario" => $usu,
                    ":senha" => $senha
                );
            } else if ($permissao == 1) {
                $sql = "SELECT cod, nome, permissao FROM usuarios WHERE permissao = :permissao AND usuario = :usuario AND senha = :senha";
                $param = array(
                    ":permissao" => $permissao,
                    ":usuario" => $usu,
                    ":senha" => $senha
                );
            }

            $dt = $this->pdo->ExecuteQueryOneRow($sql, $param);

            if ($dt != null) {
                $usuario = new Usuario();
                $usuario->setCod($dt["cod"]);
                $usuario->setNome($dt["nome"]);
                $usuario->setPermissao($dt["permissao"]);

                return $usuario;
            } else {
                return null;
            }
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()} LINE: {$ex->getLine()}";
            }
            return null;
        }
    }
    
     public function RetornarNome(int $id) {
        try {

            $sql = "SELECT * FROM usuarios WHERE cod = :cod  ORDER BY cod ASC LIMIT 1";
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
   

}
