<?php
    require '../local_config.php';
    require 'forgetobject.php';

    class ForgetObjectsDAO{
        private $pdo;
        public function __construct(){
            $this->pdo = DBConnection::getConnection();
        }

        public function findObjects() {
            $result = $this->pdo->query("SELECT idForgetObject , nameObject, description, status, registerDate, updateDate, vehicle_idVehicle, clientuser_idclientuser FROM forgetobject");
            $objects = [];

            while ($row = $result->fetch()) {
                array_push($objects, new forgetObject(
                    $row['idForgetObject'],
                    $row['nameObject'],
                    $row['description'],
                    $row['status'],
                    $row['registerDate'],
                    $row['updateDate'],
                    $row['vehicle_idVehicle'],
                    $row['clientuser_idclientuser']
                ));
            }

            return $objects;
        }

        public function saveObjects($object) {
            try{
                $stmt = $this->pdo->prepare("INSERT INTO forgetobject(nameObject,description,updateDate,Vehicle_idVehicle,clientuser_idclientuser)" .
                                            "VALUES(:nameObject,:description,CURRENT_TIMESTAMP,:Vehicle_idVehicle,:clientuser_idclientuser)");

                $stmt->execute([
                    'nameObject' => $object->getnameObject(),
                    'description' => $object->getdescription(),
                    'Vehicle_idVehicle' => $object->getVehicle_idVehicle(),
                    'clientuser_idclientuser' => $object->getclientuser_idclientuser(),
                ]);
                return "1";

            }catch(Exception $e){
                echo 'Error: ' . $e->getMessage();
            }
            return "0";
        }

        public function delete($idForgetObject) {
            try {
                $sql = "DELETE FROM forgetobject WHERE idForgetObject = :idForgetObject";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    'idForgetObject' => $idForgetObject
                ]);
                return 1;
            } catch (Exception $e) {
                echo 'Correcto: ' . $e->getMessage();
                return 0;
            }
        }
    }