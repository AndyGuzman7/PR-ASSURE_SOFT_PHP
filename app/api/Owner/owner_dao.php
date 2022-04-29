<?php
// require '../config.php';
require_once '../local_config.php';
require_once 'owner.php';
require '../codes.php';

class OwnerDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = DBConnection::GetConnection();
    }

    public function save(Owner $owner) {
        $insertPerson = "INSERT INTO person (fullName, cellphone, updateDate)
            VALUES (:fullname, :cellphone, current_timestamp)";
        $insertUser = "INSERT INTO `user` (idUser, email, password, idrolUser, updateDate)
            VALUES (:idUser, :email, MD5(:password), :role, current_timestamp)";
        $insertOwner = "INSERT INTO owner (idowner, address, ci, company_idcompany)
            VALUES (:idowner, :address, :ci, :idcompany)";
        
        try {
            $this->pdo->beginTransaction();
            $stmtPerson = $this->pdo->prepare($insertPerson);
            $stmtPerson->execute([
                'fullname' => $owner->getFullname(),
                'cellphone' => $owner->getCellphone()
            ]);

            $owner->setId($this->pdo->lastInsertId());
            $stmtUser = $this->pdo->prepare($insertUser);
            $stmtUser->execute([
                'idUser' => $owner->getId(),
                'email' => $owner->getEmail(),
                'password' => $owner->getPassword(),
                'role' => OWNER_ROLE_CODE
            ]);

            $stmtOwner = $this->pdo->prepare($insertOwner);
            $stmtOwner->execute([
                'idowner' => $owner->getId(),
                'address' => $owner->getAddress(),
                'ci' => $owner->getCi(),
                'idcompany' => $owner->getCompanyId()
            ]);

            $this->pdo->commit();
            return "success";
        }
        catch(Exception $e) {
            http_response_code(503);
            $this->pdo->rollBack();
            return $e;
        }
    }

    public function getOwnerById($ownerId) {
        $query = "SELECT P.idPerson AS 'id', 
            P.fullName AS 'fullName', 
            P.cellPhone AS 'phone', 
            P.status AS 'status', 
            U.email AS 'email', 
            U.password AS 'password', 
            O.ci AS 'ci', 
            O.address AS 'address', 
            O.company_idCompany AS 'idCompany' 
        FROM person P
        INNER JOIN user U ON U.iduser = idPerson
        INNER JOIN owner O ON O.idowner = idUser
        WHERE P.idPerson = :ownerId AND P.status = 1";

        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute(['ownerId' => $ownerId]);
            $row = $statement->fetch();
            return new Owner(
                $row['id'],
                $row['fullName'],
                $row['phone'],
                $row['email'],
                $row['password'],
                $row['address'],
                $row['ci'],
                $row['idCompany'],
                $row['status']
            );
        }
        catch(Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    public function getOwners() {
        $query = "SELECT P.idPerson AS 'id', 
            P.fullName AS 'fullName', 
            P.cellPhone AS 'phone', 
            P.status AS 'status', 
            U.email AS 'email', 
            U.password AS 'password', 
            O.ci AS 'ci', 
            O.address AS 'address', 
            O.company_idCompany AS 'idCompany' 
        FROM person P
        INNER JOIN user U ON U.iduser = idPerson
        INNER JOIN owner O ON O.idowner = idUser
        WHERE P.status = 1";

        $result = $this->pdo->query($query);
        return $this->getOwnersAsArray($result);
    }

    public function getOwnerByNameCiOrPhone($valueSearch) {
        $query = "SELECT P.idPerson AS 'id', 
            P.fullName AS 'fullName', 
            P.cellPhone AS 'phone', 
            P.status AS 'status', 
            U.email AS 'email', 
            U.password AS 'password',
            O.ci AS 'ci', 
            O.address AS 'address', 
            O.company_idCompany AS 'idCompany'
        FROM person P
        INNER JOIN user U ON U.iduser = idPerson
        INNER JOIN owner O ON O.idowner = idUser
        WHERE (P.fullName LIKE :valueSearchOne 
        OR O.ci LIKE :valueSearchTwo 
        OR P.cellphone LIKE :valueSearchThree)
        AND P.status = 1";

        $params = [
            'valueSearchOne' =>"%".$valueSearch."%",
            'valueSearchTwo' => "%".$valueSearch."%",
            'valueSearchThree' => "%".$valueSearch."%"
        ];

        $result = $this->pdo->prepare($query);
        $result->execute($params);

        return $this->getOwnersAsArray($result);
    }

    public function update(Owner $owner) {
        $queryPerson ="UPDATE person SET fullname = :fullName, cellphone = :cellphone, updateDate = CURRENT_TIMESTAMP WHERE idPerson = :idPerson";
        $queryUser ="UPDATE user SET email = :email , password = :password, updateDate = CURRENT_TIMESTAMP WHERE iduser = :iduser";
        $queryOwner = "UPDATE owner SET address=:address, ci = :ci, company_idcompany = :idcompany WHERE idowner = :idowner";

        $paramsPerson = [
            'fullName' => $owner->getFullname(),
            'cellphone' => $owner->getCellphone(),
            'idPerson' => $owner->getId()
        ];

        $paramsUser = [
            'email' => $owner->getEmail(),
            'password' => $owner->getPassword(),
            'iduser' => $owner->getId(),
        ];

        $paramsOwner = [
            'address' => $owner->getAddress(),
            'ci' => $owner->getCi(),
            'idcompany' => $owner->getCompanyId(),
            'idowner' => $owner->getId()
        ];

        try {
            $this->pdo->beginTransaction();
            
            $stmtPerson = $this->pdo->prepare($queryPerson);
            $stmtPerson->execute($paramsPerson);

            $stmtUser = $this->pdo->prepare($queryUser);
            $stmtUser->execute($paramsUser);

            $stmtOwner = $this->pdo->prepare($queryOwner);
            $stmtOwner->execute($paramsOwner);

            $this->pdo->commit();
            return "success";
        } catch (Exception $e) {
            $this->pdo->rollback();
            http_response_code(503);
            return $e;
        }
    }
    
    public function delete($idowner) {
        $query = "UPDATE person SET
            status = 0,
            updateDate = current_timestamp
            WHERE idPerson=:idPerson";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['idPerson' => $idowner]);
            return "success";
        } catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    private function getOwnersAsArray($queryResult) {
        $owners = [];

        while ($row = $queryResult->fetch()) {
            array_push($owners, new Owner(
                $row['id'],
                $row['fullName'],
                $row['phone'],
                $row['email'],
                $row['password'],
                $row['address'],
                $row['ci'],
                $row['idCompany'],
                $row['status']
            ));
        }

        return $owners;
    }

}