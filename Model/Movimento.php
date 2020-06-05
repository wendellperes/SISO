<?php

class Movimento {

    private $id;
    private $tipo;
    private $dia;
    private $mes;
    private $ano;
    private $cat;
    private $descricao;
    private $valor;
    private $cod_usu;

    function getId() {
        return $this->id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getDia() {
        return $this->dia;
    }

    function getMes() {
        return $this->mes;
    }

    function getAno() {
        return $this->ano;
    }

    function getCat() {
        return $this->cat;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getValor() {
        return $this->valor;
    }

    function getCod_usu() {
        return $this->cod_usu;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setDia($dia) {
        $this->dia = $dia;
    }

    function setMes($mes) {
        $this->mes = $mes;
    }

    function setAno($ano) {
        $this->ano = $ano;
    }

    function setCat($cat) {
        $this->cat = $cat;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setCod_usu($cod_usu) {
        $this->cod_usu = $cod_usu;
    }



}
?>








