<?php
        
class Anamnese {

   
    private $cod;
    private $cod_usu;
    private $dentista_antes;
    private $reacao_anestesia;
    private $como;
    private $alergia_medicamento;
    private $qual;
    private $outras_alergia;
    private $doencas;
    private $outra_doenca;
    private $doenca_familia;
    private $medicamento;
    private $data;
   
    

  
    
    function getCod() {
        return $this->cod;
    }

    function getCod_usu() {
        return $this->cod_usu;
    }

    function getDentista_antes() {
        return $this->dentista_antes;
    }

    function getReacao_anestesia() {
        return $this->reacao_anestesia;
    }

    function getComo() {
        return $this->como;
    }

    function getAlergia_medicamento() {
        return $this->alergia_medicamento;
    }

    function getQual() {
        return $this->qual;
    }

    function getOutras_alergia() {
        return $this->outras_alergia;
    }

    function getDoencas() {
        return $this->doencas;
    }

    function getOutra_doenca() {
        return $this->outra_doenca;
    }

    function getDoenca_familia() {
        return $this->doenca_familia;
    }

    function getMedicamento() {
        return $this->medicamento;
    }

    function getData() {
        return $this->data;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setCod_usu($cod_usu) {
        $this->cod_usu = $cod_usu;
    }

    function setDentista_antes($dentista_antes) {
        $this->dentista_antes = $dentista_antes;
    }

    function setReacao_anestesia($reacao_anestesia) {
        $this->reacao_anestesia = $reacao_anestesia;
    }

    function setComo($como) {
        $this->como = $como;
    }

    function setAlergia_medicamento($alergia_medicamento) {
        $this->alergia_medicamento = $alergia_medicamento;
    }

    function setQual($qual) {
        $this->qual = $qual;
    }

    function setOutras_alergia($outras_alergia) {
        $this->outras_alergia = $outras_alergia;
    }

    function setDoencas($doencas) {
        $this->doencas = $doencas;
    }

    function setOutra_doenca($outra_doenca) {
        $this->outra_doenca = $outra_doenca;
    }

    function setDoenca_familia($doenca_familia) {
        $this->doenca_familia = $doenca_familia;
    }

    function setMedicamento($medicamento) {
        $this->medicamento = $medicamento;
    }

    function setData($data) {
        $this->data = $data;
    }


}
?>







