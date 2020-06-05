
<?php

class Orcamento {

    private $cod;
    private $status;
    private $usuario;
    private $dia;
    private $mes;
    private $ano;
    private $func;
    
    function getFunc() {
        return $this->func;
    }

    function setFunc($func) {
        $this->func = $func;
    }

    
    
    function getCod() {
        return $this->cod;
    }

    function getStatus() {
        return $this->status;
    }

    function getUsuario() {
        return $this->usuario;
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

    function setStatus($status) {
        $this->status = $status;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
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






