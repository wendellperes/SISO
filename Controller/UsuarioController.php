<?php

if (file_exists("../DAL/UsuarioDAO.php")) {
    require_once("../DAL/UsuarioDAO.php");
} else if (file_exists("DAL/UsuarioDAO.php")) {
    require_once("DAL/UsuarioDAO.php");
} else {
    require_once("../../DAL/UsuarioDAO.php");
}

class UsuarioController {

    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function Cadastrar($usuario) {
        if (
                strlen($usuario->getNome()) >= 5
        ) {
            return $this->usuarioDAO->Cadastrar($usuario);
        } else {
            return false;
        }
    }

    public function RetornarUsuarios(string $termo, int $tipo, int $status) {
        if (strlen($termo) >= 0 && $tipo > 0 && $status >= 0) {
            return $this->usuarioDAO->RetornarUsuarios($termo, $tipo, $status);
        } else {
            return false;
        }
    }

    public function Alterar($usuario) {
        if (
                strlen($usuario->getNome()) >= 5
        ) {
            return $this->usuarioDAO->Alterar($usuario);
        } else {
            return false;
        }
    }

    public function Deletar2(int $coddeletar) {
        if ($coddeletar != 0) {
            return $this->usuarioDAO->Deletar2($coddeletar);
        } else {
            return false;
        }
    }

    public function AutenticarUsuario(string $usu, string $senha, int $permissao) {
        if (strlen($usu) >= 1 && strlen($senha) >= 1 && $permissao > 0 && $permissao < 4) {
            $senha = md5($senha);
            return $this->usuarioDAO->AutenticarUsuario($usu, $senha, $permissao);
        } else {
            return null;
        }
    }
    public function RetornarNome(int $id) {
        if (1 == 1) {
            return $this->usuarioDAO->RetornarNome($id);
        } else {
            return null;
        }
    }

}
