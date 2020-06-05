<?php

class CategoriaFinanceiro {

    private $id;
    private $nome;
    private $cod_usu;
   
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getCod_usu() {
        return $this->cod_usu;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setCod_usu($cod_usu) {
        $this->cod_usu = $cod_usu;
    }



}
?>








