<?php

/**
 * Data Access Object for Driver table
 * 
 * Processes sql statements to access/manipulate driver
 * table on database and related.
 * 
 * @author Fabricio Rene Crespo Rossel
 */

require_once '../local_config.php';
// require_once '../local_config.php';
require_once '../driver/driver.php';
require_once '../vehicle/vehicle.php';
require_once 'driver_has_vehicle.php';

class DriverHasVehicleDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DBConnection::GetConnection();
    }

    /**
     * Returns all driver's with vehicles data from database
     * @param string $pleik text to search for matching
     * @return array<Driver|Vehicle> drivers
     */
    public function getVehicleAndDriverByPleik($pleik) {
        $query = "SELECT 
            DV.driver_has_vehiclecol AS 'idDriverHasVehicle',
            D.iddriver AS 'idDriver',
            P.fullName AS 'fullname', 
            P.cellphone AS 'cellphone',
            D.license AS 'license',
            D.ci AS 'ci', 
            D.photo AS 'picture',
            V.idvehicle AS 'idVehicle',
            V.pleik AS 'pleik', 
            V.model AS 'model',
            V.capacity AS 'capacity',
            V.color AS 'color', 
            V.photo AS 'pictureVehicle',
            V.owner_idowner AS 'idOwner'
        FROM vehicle V
        RIGHT JOIN driver_has_vehicle DV ON DV.vehicle_idvehicle = V.idvehicle  
        RIGHT JOIN driver D ON D.iddriver = DV.driver_iddriver
        INNER JOIN person P ON D.iddriver = P.idPerson
        WHERE V.pleik = :pleik AND DV.state = 1";
        
        $params = ['pleik' => $pleik];
        
        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            $result = $statement->fetch();
            
            if($result) {  

                $driver = new Driver(
                    $result['idDriver'], $result['fullname'],
                    $result['cellphone'], $result['license'],
                    $result['ci'], $result['picture'], $result['idOwner']
                );

                $vehicle = new Vehicle(
                    $result['idVehicle'], $result['color'],
                    $result['model'], $result['pleik'],
                    $result['capacity'], $result['pictureVehicle'],
                    $result['idOwner']
                );

                return array(
                    "idDriverHasVehicle" => $result['idDriverHasVehicle'],
                    "driver" => $driver,
                    "vehicle" => $vehicle
                );
            }
            else {
                http_response_code(404);
                return 'unregistered vehicle';
            }
        }
        catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    function getVehicleAndDriverByDriverId($driverId) {
        $query = "SELECT
            DV.driver_has_vehiclecol AS 'idDriverHasVehicle',
            D.iddriver AS 'idDriver',
            P.fullName AS 'fullname', 
            P.cellphone AS 'cellphone', 
            D.license AS 'license',
            D.ci AS 'ci', 
            D.photo AS 'picture',
            V.idvehicle AS 'idVehicle',
            V.pleik AS 'pleik', 
            V.model AS 'model', 
            V.color AS 'color', 
            V.capacity AS 'capacity',
            V.photo AS 'pictureVehicle',
            V.owner_idowner AS 'idOwner'
        FROM driver D
        RIGHT JOIN driver_has_vehicle DV ON DV.driver_iddriver = D.iddriver
        RIGHT JOIN vehicle V ON V.idvehicle = DV.vehicle_idVehicle
        INNER JOIN person P ON D.iddriver = P.idPerson
        WHERE D.iddriver = :driverId AND DV.state = 1";
        
        $params = ['driverId' => $driverId];
        
        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            $result = $statement->fetch();
            
            if($result) {  

                $driver = new Driver(
                    $result['idDriver'], $result['fullname'],
                    $result['cellphone'], $result['license'],
                    $result['ci'], $result['picture'], $result['idOwner']
                );

                $vehicle = new Vehicle(
                    $result['idVehicle'], $result['color'],
                    $result['model'], $result['pleik'],
                    $result['capacity'], $result['pictureVehicle'],
                    $result['idOwner']
                );

                return array(
                    "idDriverHasVehicle" => $result['idDriverHasVehicle'],
                    "driver" => $driver,
                    "vehicle" => $vehicle
                );
            }
            else {
                http_response_code(404);
                return 'unregistered driver';
            }
        }
        catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    function getVehicleAndDriverByVehicleId($vehicleId) {
        $query = "SELECT
            DV.driver_has_vehiclecol AS 'idDriverHasVehicle',
            D.iddriver AS 'idDriver',
            P.fullName AS 'fullname', 
            P.cellphone AS 'cellphone', 
            D.license AS 'license',
            D.ci AS 'ci', 
            D.photo AS 'picture',
            V.idvehicle AS 'idVehicle',
            V.pleik AS 'pleik', 
            V.model AS 'model', 
            V.color AS 'color', 
            V.capacity AS 'capacity',
            V.photo AS 'pictureVehicle',
            V.owner_idowner AS 'idOwner'
        FROM vehicle V
        RIGHT JOIN driver_has_vehicle DV ON DV.vehicle_idVehicle = V.idVehicle
        RIGHT JOIN driver D ON D.iddriver = DV.driver_iddriver
        INNER JOIN person P ON D.iddriver = P.idPerson
        WHERE V.idVehicle = :vehicleId AND DV.state = 1";
        
        $params = ['vehicleId' => $vehicleId];
        
        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            $result = $statement->fetch();
            
            if($result) {  

                $driver = new Driver(
                    $result['idDriver'], $result['fullname'],
                    $result['cellphone'], $result['license'],
                    $result['ci'], $result['picture'], $result['idOwner']
                );

                $vehicle = new Vehicle(
                    $result['idVehicle'], $result['color'],
                    $result['model'], $result['pleik'],
                    $result['capacity'], $result['pictureVehicle'],
                    $result['idOwner']
                );

                return array(
                    "idDriverHasVehicle" => $result['idDriverHasVehicle'],
                    "driver" => $driver,
                    "vehicle" => $vehicle
                );
            }
            else {
                http_response_code(404);
                return 'unregistered driver';
            }
        }
        catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    /**
     * Inserts data into table DriverHasVehicle 
     * @param $jsonDriverHasVehicle is DriverHasVehicle object transformed to json format
     */
    public function insert($jsonDriverHasVehicle)
    {
        $driverhasvehicle = new DriverHasVehicle(
            0,
            intval($jsonDriverHasVehicle['iddriver']),
            intval($jsonDriverHasVehicle['idvehicle']),
            1
        );

        try {
            $query = "INSERT INTO driver_has_vehicle
            (`driver_iddriver`,`vehicle_idVehicle`, `initialDate`)
            VALUES
            (:driver_iddriver, :vehicle_idVehicle, current_timestamp)";
            $params = [
                "driver_iddriver" => $driverhasvehicle->iddriver,
                "vehicle_idVehicle" => $driverhasvehicle->idvehicle,
            ];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            return "success";
        } catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    /**
     * Enables a driver to use vehicle
     * @param $id is given by the selected driverhasvehicle connected in the screen
     */
    public function enableDriver(DriverHasVehicle $driverHasVehicle)
    {
        try {
            $query = "INSERT INTO driver_has_vehicle(driver_iddriver,initialDate, vehicle_idvehicle) VALUES(:idDriver,current_timestamp(),:idVehicle )";
            $params = [
                'idDriver' => $driverHasVehicle->iddriver,
                'idVehicle' => $driverHasVehicle->idvehicle
            ];

            $result = $this->pdo->prepare($query);
            $result->execute($params);
            return "success";
        } catch (Exception $e) {
            http_response_code(503);
            echo json_encode($e);
        }
    }

    /**
     * Disables a driver to use vehicle
     * @param $id is given by the selected driverhasvehicle connected in the screen
     */
    public function disableDriver($id)
    {
        try {
            $query = "UPDATE driver_has_vehicle SET state = 0, endDate = CURRENT_TIMESTAMP WHERE driver_has_vehiclecol = :iddriverhasvehicle";
            $params = [
                'iddriverhasvehicle' => $id
            ];

            $result = $this->pdo->prepare($query);
            $result->execute($params);
            return "success";
        } catch (Exception $e) {
            http_response_code(503);
            echo json_encode($e);
        }
    }
}
