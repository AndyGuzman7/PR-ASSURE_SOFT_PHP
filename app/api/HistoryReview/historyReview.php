<?php
class HistoryReview implements JsonSerializable {
    public $idDriver;
    public $idClientUser;
    public $name;
    public $pleik;
    public $photo;
    public $coment;
    public $dataRegister;
    public $calification;

    public function __construct($idDriver, $idClientUser, $name, $pleik, $photo, $coment, $dataRegister, $calification) {
        $this->idDriver = $idDriver;
        $this->idClientUser = $idClientUser;
        $this->name = $name;
        $this->pleik = $pleik;
        $this->photo = $photo;
        $this->coment = $coment;
        $this->dataRegister = $dataRegister;
        $this->calification = $calification;
    }

    public function jsonSerialize()
    {
        return [
            'idDriver' => $this->idDriver,
            'idClientUser' => $this->idClientUser,
            'name' => $this->name,
            'pleik' => $this->pleik,
            'photo' => $this->photo,
            'coment' => $this->coment,
            'dataRegister' => $this->dataRegister,
            'calification' => $this->calification
        ];
    }
}