<?php
// require '../config.php';

require_once '../local_config.php';
require_once 'vehicle.php';

class VehicleDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = DBConnection::GetConnection();
    }

    public function getAll() {
        $query = "SELECT 
                idVehicle AS 'id',
                color, model,
                pleik, capacity,
                photo AS 'picture',
                owner_idowner AS 'ownerId'
            FROM vehicle
            WHERE status = 1";

        try {
            $result = $this->pdo->query($query);
            return $this->getVehiclesAsArray($result);
        }
        catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    public function getVehiclesByOwner($ownerId) {
        $query = "SELECT 
                idVehicle AS 'id',
                color, model,
                pleik, capacity,
                photo AS 'picture',
                owner_idowner AS 'ownerId'
            FROM vehicle
            WHERE owner_idowner = :ownerId AND status = 1";
        $params = ['ownerId' => $ownerId];

        try {
            $result = $this->pdo->prepare($query);
            $result->execute($params);
            return $this->getVehiclesAsArray($result);
        }
        catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    public function updateVehicle($vehicle) {
        $query = "UPDATE vehicle SET
            color = :color,
            model = :model,
            pleik = :pleik,
            capacity = :capacity,
            photo = :photo,
            updateDate = CURRENT_TIMESTAMP,
            owner_idowner = :owner_idowner
        WHERE idVehicle = :idVehicle";

        $params = [
            'idVehicle' => $vehicle->getIdVehicle(),
            'color' =>$vehicle->getColor(),
            'model' =>$vehicle->getModel(),
            'pleik' => $vehicle->getPleik(),
            'capacity' => $vehicle->getCapacity(),
            'photo' => $vehicle->getPicture(),
            'owner_idowner' => $vehicle->getOwnerId(),
        ];

        try {
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute($params);
	    if($result) {
	    	return "success";
	    }
	    http_response_code(503);
            return "failed";
        }
        catch(Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    private function getVehiclesAsArray($queryResult) {
        $vehicles = [];
        while($row = $queryResult->fetch()) {
            array_push($vehicles, new Vehicle(
                $row['id'],
                $row['color'],
                $row['model'],
                $row['pleik'],
                $row['capacity'],
                $row['picture'],
                $row['ownerId']
            ));
        }

        return $vehicles;
    }

    public function insertVehicle(Vehicle $vehicle){
        $insertSql = "INSERT INTO vehicle(color, model,pleik,capacity,photo,updateDate,owner_idowner)
            VALUES (:color,:model,:placa,:capacidad,:photo, current_timestamp,:owner_idowner)";
        try {
            $statement = $this->pdo->prepare($insertSql);
            $result = $statement->execute([
                'color' => $vehicle->getColor(),
                'model' => $vehicle->getModel(),
                'placa' => $vehicle->getPleik(),
                'capacidad' => $vehicle->getCapacity(),
                'photo' => $vehicle->getPicture(),
                'owner_idowner'=> $vehicle->getOwnerId()
            ]);
            if ($result) {
		return "success";
	    }
	    http_response_code(503);
            return "failed";

        } catch (Exception $e) {
            http_response_code(503);
            return $e;
        }

    }
}
