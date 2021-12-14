<?php
/**
 * @author Yhonattan David Llanos Rivera
 */
// require_once '../config.php';
require_once '../local_config.php';
require '../codes.php';
require 'user.php';

class UserDAO{
    private $conn;
    /**
     * Llamar Metodo Para Conectar con BD
     */
    public function __construct() {
        $this->conn = \DBConnection::GetConnection();
    }

    public function getPhoneByEmail($email){
        $query = "SELECT P.cellphone FROM person P 
            INNER JOIN user U ON U.iduser = P.idPerson
            WHERE U.email = :email";
        try {
            $this->conn->beginTransaction();
            $getPhone = $this->conn->prepare($query);
            $getPhone->execute(['email' => $email]);
            $phone = "";

            while ($row = $getPhone->fetch()) {
                $phone = $row['cellphone'];
            }

            $this->conn->commit();

            if($phone != ""){
                return $phone;
            }
            return "Error";
        }
        catch (\Exception $e) {
            $this->conn->rollBack();
            return "Error: ".$e->getMessage();
        }
    }

    public function getIdByEmail($email){
        $query = "SELECT P.idPerson FROM person P 
            INNER JOIN user U ON U.iduser = P.idPerson
            WHERE U.email = :email";
        try {
            $getId = $this->conn->prepare($query);
            $getId->execute(['email' => $email]);
            $id = $getId->fetch()['idPerson'];

            if($id == null) {
                http_response_code(404);
                return "email not registered";
            }
            return ["id" => $id];
        }
        catch (\Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    public function getEmergencyContactsById($idUser){
        $query = "SELECT `number` FROM emergencycontact
            WHERE clientuser_idclientuser = :idPerson";

        try{
            $getPhone = $this->conn->prepare($query);
            $getPhone->execute(['idPerson' => $idUser]);

            $phone = array();
            while ($row = $getPhone->fetch()) {
                array_push($phone, $row['number']);
            }

            if(count($phone) > 0){
                return $phone;
            }

            http_response_code(404);
            return "does not exists";
        }
        catch(\Exception $e){
            http_response_code(503);
            return $e;
        }
        
    }

    public function updatePassword($email,$password) {
        try {
            $query = "UPDATE user SET
                password = MD5(:password)
            WHERE email = :email";
            $params = [
                "password" => $password,
                "email" => $email,
            ];

            $statement = $this->conn->prepare($query);
            $result = $statement->execute($params);
            if($result) {
                return "success";
            }
            
            http_response_code(503);
            return "unable to update password";
        }
        catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    public function getClientUserById($idclientuser) {
        $query = "SELECT
                P.idPerson AS 'id',
                fullname AS 'fullname',
                cellphone AS 'cellphone',
                U.email AS 'email',
                U.registerDate AS 'createdAt',
                U.updateDate AS 'updatedAt',
                U.status AS 'status'
            FROM user U
            INNER JOIN Person P ON U.iduser = P.idPerson
            WHERE U.iduser = :idclientuser";

        $params = ["idclientuser" => $idclientuser];

        try {
            $statement = $this->conn->prepare($query);
            $statement->execute($params);

            $row = $statement->fetch();
            return new User(
                $row['email'],
                'N/A', 'N/A',
                $row['id'],
                $row['fullname'],
                $row['cellphone'],
                $row['createdAt'],
                $row['updatedAd'],
                $row['status']
            );

            http_response_code(503);
            return "unable to get user";

        } catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }
}