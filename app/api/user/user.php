<?php
/**
 * @author Yhonattan David Llanos Rivera
 */
require 'person.php';

class User extends Person implements JsonSerializable {
    private $email;
    private $password;
    private $typeRegister;

    public function __construct($email="N/A", $password="N/A",$typeRegister,$idPerson,
    $fullName,$cellphone,$registerData, $updateData, $status)
    {
        parent::__construct($idPerson,$fullName,$cellphone,
        $registerData, $updateData, $status);
        $this->email=$email;
        $this->password = $password;
        $this->typeRegister = $typeRegister;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getTypeRegister() {
        return $this->typeRegister;
    }

    public function setTypeRegister($typeRegister) {
        $this->typeRegister = $typeRegister;
    }

    public function jsonSerialize() {
        return [
            'idPerson' => $this->getIdPerson(),
            'fullname' => $this->getFullName(),
            'cellphone' => $this->getCellphone(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'typeRegister' => $this->getTypeRegister(),
        ];
    }
}
