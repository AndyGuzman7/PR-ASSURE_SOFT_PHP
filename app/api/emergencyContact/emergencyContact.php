<?php
class EmergencyContact implements \JsonSerializable {
    private $idEmergencyContact;
    private $nameContact;
    private $number;
    private $idClientUser;

    public function __construct($idEmergencyContact, $nameContact, $number, $idClientUser)
    {
        $this->idEmergencyContact=$idEmergencyContact;
        $this->nameContact = $nameContact;
        $this->number = $number;
        $this->idClientUser = $idClientUser;
    }

    public function jsonSerialize() {
        return [
            'idEmergencyContact' => $this->idEmergencyContact,
            'nameContact' => $this->nameContact,
            'number' => $this->number,
            'idClientUser' => $this->idClientUser,
        ];
    }

    public function getIdEmergencyContact()
    {
        return $this->idEmergencyContact;
    }

    public function getNameContact()
    {
        return $this->nameContact;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getIdClientUser()
    {
        return $this->idClientUser;
    }
}
