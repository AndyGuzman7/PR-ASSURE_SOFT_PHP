<?php
/**
 * @author Yhonattan David Llanos Rivera
 */
require 'audit_data.php';

class Person extends AuditData implements JsonSerializable{
    private $idPerson;
    private $fullName;
    private $cellphone;
    
    public function __construct($idPerson="N/A",$fullName="N/A",$cellphone="S/N",
    $registerData, $updateData, $status){
        parent::__construct($registerData, $updateData, $status);
        $this->idPerson=$idPerson;
        $this->fullName=$fullName;
        $this->cellphone=$cellphone;
    }

    public function getIdPerson(){
        return $this->idPerson;
    }

    public function setIdPerson($idPerson){
        $this->idPerson = $idPerson;
    }

    public function getFullName(){
        return $this->fullName;
    }

    public function setFullName($fullName){
        $this->fullName = $fullName;
    }

    public function getCellphone(){
        return $this->cellphone;
    }

    public function setCellphone($cellphone){
        $this->cellphone = $cellphone;
    }
    
    public function jsonSerialize(){
        return [
            'idPerson' => $this->idPerson,
            'fullName' => $this->fullName,
            'cellphone' => $this->cellphone,
        ];
    }
}

?>