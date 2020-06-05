<?php

class Dente {

    private $cod;
    private $nome;
    private $descricao;
    private $quadrante;
    private $imagem;

    function getCod() {
        return $this->cod;
    }

    function getNome() {
        return $this->nome;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getQuadrante() {
        return $this->quadrante;
    }

    function getImagem() {
        return $this->imagem;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setQuadrante($quadrante) {
        $this->quadrante = $quadrante;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }



}
?>








