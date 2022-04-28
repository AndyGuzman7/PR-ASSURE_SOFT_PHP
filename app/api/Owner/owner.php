<?php
        class Owner implements JsonSerializable {
        protected $id;
        protected $fullName;
        protected $cellphone;
        protected $email;
        protected $password;
        protected $address;
        protected $ci;
        protected $idCompany;
        protected $status;
        

        public function __construct($id, $fullName, $cellphone, $email, $password, $address, $ci, $idCompany, $status) {
            $this->id = $id;
            $this->fullName = $fullName;
            $this->cellphone = $cellphone;
            $this->email = $email;
            $this->password = $password;
            $this->address = $address;
            $this->ci = $ci;
            $this->idCompany = $idCompany;
            $this->status = $status;
        }

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }


        public function getAddress(){
            return $this->address;
        }
        public function setAddress($address){
            $this->address = $address;
        }

        public function getCi(){
            return $this->ci;
        }
        public function setCi($ci){
            $this->ci = $ci;
        }

        public function getCompanyId(){
            return $this->idCompany;
        }
        public function setCompanyId($idCompany){
            $this->idCompany = $idCompany;
        }

        
        public function getCellphone(){
            return $this->cellphone;
        }
        public function setCellphone($cellphone){
            $this->cellphone = $cellphone;
        }


        public function getFullname(){
            return $this->fullName;
        }
        public function setFullname($fullName){
            $this->fullname = $fullName;
        }

        public function getEmail(){
            return $this->email;
        }
        public function setEmail($email){
            $this->email = $email;
        }

        public function getPassword(){
            return $this->password;
        }
        public function setPassword($password){
            $this->password = $password;
        }

        public function getStatus(){
            return $this->status;
        }
        
        public function setStatus($status){
            $this->status = $status;
        }

        public function jsonSerialize() {
            return [
                'id' => $this->id,
                'fullName' => $this->fullName,
                'cellphone' => $this->cellphone,
                'email' => $this->email,
                'password' => $this->password,
                'address' => $this->address,
                'ci' => $this->ci,
                'idCompany' => $this->idCompany,
                'status' => $this->status
            ];
        }

        
    }
