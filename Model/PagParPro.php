<?php

class PagParPro {

    private $cod;
    private $descricao;
    private $valor;
    private $financeiro_pac;
    private $tipopag;
    private $dia;
    private $mes;
    private $ano;
    private $esp_pro;

    function getCod() {
        return $this->cod;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getValor() {
        return $this->valor;
    }

    function getFinanceiro_pac() {
        return $this->financeiro_pac;
    }

    function getTipopag() {
        return $this->tipopag;
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

    function getEsp_pro() {
        return $this->esp_pro;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setFinanceiro_pac($financeiro_pac) {
        $this->financeiro_pac = $financeiro_pac;
    }

    function setTipopag($tipopag) {
        $this->tipopag = $tipopag;
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

    function setEsp_pro($esp_pro) {
        $this->esp_pro = $esp_pro;
    }



}
?>









