<?php

class Pagamento {

    private $cod;
    private $cod_orcamento;
    private $tipo;
    private $subtotal;
    private $total;
    private $descricao;
    private $tipopag;
    private $numparcelas;
    private $dia;
    private $mes;
    private $ano;

    function getCod() {
        return $this->cod;
    }

    function getCod_orcamento() {
        return $this->cod_orcamento;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getSubtotal() {
        return $this->subtotal;
    }

    function getTotal() {
        return $this->total;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getTipopag() {
        return $this->tipopag;
    }

    function getNumparcelas() {
        return $this->numparcelas;
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

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setCod_orcamento($cod_orcamento) {
        $this->cod_orcamento = $cod_orcamento;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setTipopag($tipopag) {
        $this->tipopag = $tipopag;
    }

    function setNumparcelas($numparcelas) {
        $this->numparcelas = $numparcelas;
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



}
?>








