<?php
    class forgetObject implements JsonSerializable {
        private $idForgetObject;
        private $nameObject;
        private $description;
        private $status;
        private $registerData;
        private $updateData;
        private $Vehicle_idVehicle;
        private $clientuser_idclientuser;

        
        

        public function __construct($nameObject, $description,$Vehicle_idVehicle, $clientuser_idclientuser,$idForgetObject = null,$status=null,$registerData=null,$updateData=null) {
            $this->idForgetObject = $idForgetObject;
            $this->nameObject = $nameObject;
            $this->description = $description;
            $this->status = $status;
            $this->registerData = $registerData;
            $this->updateData = $updateData;
            $this->Vehicle_idVehicle = $Vehicle_idVehicle;
            $this->clientuser_idclientuser = $clientuser_idclientuser;
        }
        public function getidForgetObject() {
            return $this->idForgetObject;
        }

        public function setidForgetObject($idForgetObject) {
            $this->idForgetObject = $idForgetObject;
        }


        public function getnameObject(){
            return $this->nameObject;
        }
        public function setnameObject($nameObject){
            $this->nameObject = $nameObject;
        }

        public function getdescription(){
            return $this->description;
        }
        public function setdescription($description){
            $this->description = $description;
        }

        public function GetStatus(){
            return $this->status;
        }
        public function SetStatus($status){
            $this->status = $status;
        }

        public function GetRegisterData(){
            return $this->registerData;
        }
        public function SetRegisterData($registerData){
            $this->registerData = $registerData;
        }public function GetUpdateDate(){
            return $this->updateData;
        }

        public function SetUpdateDate($updateData){
            $this->updateData = $updateData;
        }
        public function getVehicle_idVehicle() {
            return $this->Vehicle_idVehicle;
        }


        public function setVehicle_idVehicle($Vehicle_idVehicle) {
            $this->Vehicle_idVehicle = $Vehicle_idVehicle;
        }

        public function getclientuser_idclientuser() {
            return $this->clientuser_idclientuser;
        }

        public function setclientuser_idclientuser($clientuser_idclientuser) {
            $this->clientuser_idclientuser = $clientuser_idclientuser;
        }


        public function jsonSerialize() {
            return [
                'idForgetObject' => $this->idForgetObject,
                'nameObject' => $this->nameObject,
                'description' => $this->description,
                'status' => $this->status,
                'registerDate' => $this->registerData,
                'updateDate' => $this->updateData,
                'Vehicle_idVehicle'=> $this->Vehicle_idVehicle,
                'clientuser_idclientuser' => $this->clientuser_idclientuser
            ];
        }
    }