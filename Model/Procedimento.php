<?php

class Procedimento {

    private $cod;
    private $dente;
    private $servico;
    private $usuario;
    private $valor;
    private $status;
    private $nivel;
    private $obs;
    private $tipo;
    private $dia;
    private $mes;
    private $ano;
    private $categoria;
    
    function getCod() {
        return $this->cod;
    }

    function getDente() {
        return $this->dente;
    }

    function getServico() {
        return $this->servico;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getValor() {
        return $this->valor;
    }

    function getStatus() {
        return $this->status;
    }

    function getNivel() {
        return $this->nivel;
    }

    function getObs() {
        return $this->obs;
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

    function getCategoria() {
        return $this->categoria;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setDente($dente) {
        $this->dente = $dente;
    }

    function setServico($servico) {
        $this->servico = $servico;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    function setObs($obs) {
        $this->obs = $obs;
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

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }


}
?>








