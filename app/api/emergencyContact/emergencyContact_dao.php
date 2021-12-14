<?php
require '../local_config.php';
require 'emergencyContact.php';

class EmergencyContactDAO {
    private $pdo;
    
    public function __construct() {
        $this->pdo = DBConnection::GetConnection();
    }

    public function getEmergencyContactsById($idclientuser) {
        $query = "SELECT 
            idEmergencyContact AS 'id',
            nameContact AS 'contactName',
            number AS 'number',
            clientuser_idclientuser AS 'clientId'
            FROM emergencycontact
            WHERE clientuser_idclientuser = :idclientuser";

        $params = ["idclientuser" => $idclientuser];

        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);

            return $this->getEmergencyContactsAsArray($statement);

        } catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }
    
    public function insert($contact) {
        $query = "INSERT INTO
            emergencycontact(nameContact, number, clientuser_idclientuser)
            VALUES (:nameContact, :number, :idClientUser)";
            
        $params = [
            "nameContact" => $contact->getNameContact(),
            "number" => $contact->getNumber(),
            "idClientUser" => $contact->getIdClientUser(),
        ];

        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            if($statement) {
                return "success";
            }
            else {
                http_response_code(503);
                return "failed";
            }

        } catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    public function update($contact) {
        try {
            $query = "UPDATE emergencycontact SET
                nameContact = :nameContact,
                number = :number
            WHERE idEmergencyContact = :idEmergencyContact";
            $params = [
                "idEmergencyContact" => $contact->getIdEmergencyContact(),
                "nameContact" => $contact->getNameContact(),
                "number" => $contact->getNumber(),
            ];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            if($statement) {
                return "success";
            }
            else {
                http_response_code(503);
                return "failed";
            }
        } catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    public function delete($contact) {
        try {
            $query = "DELETE FROM emergencycontact 
                WHERE idEmergencyContact = :id";
            $params = [
                "id" => $contact->getIdEmergencyContact(),
            ];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            if($statement) {
                return "success";
            }
            else {
                http_response_code(503);
                return "failed";
            }

        } catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    private function getEmergencyContactsAsArray($queryResult) {
        $array = [];

        while ($row = $queryResult->fetch()) 
        {
            array_push($array, new EmergencyContact(
                $row['id'],
                $row['contactName'],
                $row['number'],
                $row['clientId']
            ));
        }
        return $array;
    }
}