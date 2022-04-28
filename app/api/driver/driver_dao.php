<?php
/**
 * Data Access Object for Driver table
 * 
 * Processes sql statements to access/manipulate driver
 * table on database and related.
 * 
 * @author Sofia Valeria Toro Chambi
 */


// require '../config.php';
require_once '../local_config.php';
require_once 'driver.php';

class DriverDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = DBConnection::GetConnection();
    }

    public function insert(Driver $driver) {
        $insertPerson = "INSERT INTO person (fullName, cellphone, updateDate)
            VALUES (:fullname, :cellphone, NOW())";
        
        $insertDriver = "INSERT INTO driver
            (iddriver, license, ci, photo, updateDate, email, password, owner_idowner)
            VALUES (:iddriver, :license, :ci, :photo, NOW(), :email, MD5(:password), :ownerId)";

        $paramsPerson = [
            'fullname' => $driver->getFullname(),
            'cellphone' => $driver->getCellphone()
        ];

        try {
            $this->pdo->beginTransaction();
            
            $stmtPerson = $this->pdo->prepare($insertPerson); 
            $stmtPerson->execute($paramsPerson);
            
            $driver->setId($this->pdo->lastInsertId());
            
            $stmtDriver = $this->pdo->prepare($insertDriver);
            $stmtDriver->execute([
                'iddriver' => $driver->getId(),
                'license' => $driver->getLicense(),
                'ci' => $driver->getCi(),
                'photo' => $driver->getPicture(),
                'email' => $driver->getEmail(),
                'password' => $driver->getPassword(),
                'ownerId' => $driver->getOwnerId(),
            ]);
            
            $this->pdo->commit();
            return "success";
        }
        catch (Exception $e) {
            $this->pdo->rollback();
            http_response_code(503);
            return $e;
        }
    }

    /**
     * Returns all drivers from database
     * @return array<Driver> drivers
     */
    public function getDriversByOwner($ownerId) {
        $query = "SELECT
            d.iddriver AS 'id',
            p.fullName AS 'fullName',
            p.cellphone AS 'cellphone',
            d.license AS 'license',
            d.ci AS 'ci',
            d.photo AS 'picture',
            d.owner_idowner AS 'ownerId',
            d.status AS 'status',
            d.email AS 'email',
            d.password AS 'password'
        FROM driver d
        INNER JOIN person p ON d.iddriver = p.idPerson
        WHERE d.owner_idowner = :ownerId AND p.status = 1";

        $params = ['ownerId' => $ownerId];

        try {
            $result = $this->pdo->prepare($query);
            $result->execute($params);
            return $this->getDriversAsArray($result);
        }
        catch(\Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    /**
     * Performs a sql statement to find matches on name or ci
     * @param string $criteria text to search for matching
     * @return array<Driver> drivers who match
     */
    public function getDriversByNameOrCi($criteria, $ownerId) {
        $query = "SELECT
            d.iddriver AS 'id',
            p.fullName AS 'fullName',
            p.cellphone AS 'cellphone',
             d.license AS 'license',
            d.ci AS 'ci',
            d.photo AS 'picture',
            d.owner_idowner AS 'ownerId',
            d.status AS 'status',
            d.email AS 'email',
            d.password AS 'password'
        FROM driver d
        INNER JOIN person p ON d.iddriver = p.idPerson
        WHERE (p.fullName LIKE :nameCriteria OR d.ci LIKE :ciCriteria)
        AND d.owner_idowner = :ownerId AND p.status = 1";

        $params = [
            'nameCriteria' => '%'.$criteria.'%',
            'ciCriteria' => '%'.$criteria.'%',
            'ownerId' => $ownerId
        ];

        try {
            $result = $this->pdo->prepare($query);
            $result->execute($params);
            return $this->getDriversAsArray($result);
        }
        catch (\Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    /**
     * Converts result from a sql statement to an array
     * @param $queryResult result from execution of query
     * @return array<Driver> drivers converted to array
     */
    private function getDriversAsArray($queryResult) {
        $drivers = [];
        while ($row = $queryResult->fetch()) {
            array_push($drivers, new Driver(
                $row['id'],
                $row['fullName'],
                $row['cellphone'],
                $row['license'],
                $row['ci'],
                $row['picture'],
                $row['ownerId'],
                $row['email'],
                $row['password'],
                $row['status']
            ));
        }

        return $drivers;
    }

    public function delete($iddriver) {
        $query = "UPDATE person SET
            status = 0,
            updateDate = current_timestamp
            WHERE idPerson= :idPerson";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['idPerson' => $iddriver]);
            return "success";
        } catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    public function update(Driver $driver) {

        $queryPerson ="UPDATE person SET
                fullname = :fullName,
                cellphone = :cellphone,
                updateDate = CURRENT_TIMESTAMP
            WHERE idPerson = :idPerson";
        
        $queryDriver = "UPDATE driver SET
                license =:license,
                ci = :ci,
                photo = :picture,
                email = :email,
                password = :password
            WHERE iddriver = :iddriver";

        $paramsPerson = [
            'fullName' => $driver->getFullname(),
            'cellphone' => $driver->getCellphone(),
            'idPerson' => $driver->getId()
        ];     

        $paramsDriver = [            
            'ci' => $driver->getCi(),
            'license' => $driver->getLicense(),
            'picture' => $driver->getPicture(),
            'iddriver' => $driver->getId(),
            'email' => $driver->getEmail(),
            'password' => $driver->getPassword()
        ];

        try {
            $this->pdo->beginTransaction();
            
            $stmtPerson = $this->pdo->prepare($queryPerson);
            $stmtPerson->execute($paramsPerson);            

            $stmtDriver = $this->pdo->prepare($queryDriver);
            $stmtDriver->execute($paramsDriver);

            $this->pdo->commit();
            return "success";
        } catch (Exception $e) {
            $this->pdo->rollback();
            http_response_code(503);
            return $e;
        }
    }
}
