<?php

class Listaespera {

    private $cod;
    private $cod_paciente;
    private $data;

    function getCod() {
        return $this->cod;
    }

    function getCod_paciente() {
        return $this->cod_paciente;
    }

    function getData() {
        return $this->data;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setCod_paciente($cod_paciente) {
        $this->cod_paciente = $cod_paciente;
    }

    function setData($data) {
        $this->data = $data;
    }



}
?>







