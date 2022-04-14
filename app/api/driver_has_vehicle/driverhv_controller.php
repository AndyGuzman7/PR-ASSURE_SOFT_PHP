<?php

/**
 * Controller for Driver related requests  
 * 
 * Selects the correct method to execute according to http request method
 * using Driver DAO (Data Access Object).
 * 
 * @see Driver\DriverHvDAO
 * @author Fabricio Rene Crespo Rossel
 */


/**Processes requests received making use of queries */
require 'driverhv_dao.php';

header("Content-Type: application/json");
$requestMethod = $_SERVER['REQUEST_METHOD'];
$driverHasVehicleDAO = new DriverHasVehicleDAO();

switch ($requestMethod) {
    case 'GET':
        if (!empty($_GET['pleik'])) {
            $pleik = $_GET['pleik'];
            echo json_encode($driverHasVehicleDAO->getVehicleAndDriverByPleik($pleik));
        }
        else if (!empty($_GET['driverId'])) {
            $driverId = $_GET['driverId'];
            echo json_encode($driverHasVehicleDAO->getVehicleAndDriverByDriverId($driverId));
        }
        else if (!empty($_GET['vehicleId'])) {
            $vehicleId = $_GET['vehicleId'];
            echo json_encode($driverHasVehicleDAO->getVehicleAndDriverByVehicleId($vehicleId));
        }
        break;
    case 'POST':
        $jsonDriverHasVehicle = json_decode(file_get_contents("php://input"), true);
        echo json_encode($driverHasVehicleDAO->insert($jsonDriverHasVehicle));
        break;
    case 'PUT':
        $jsonDriverHasVehicle = json_decode(file_get_contents("php://input"), true);
        $iddriver = $jsonDriverHasVehicle['iddriver'];
        echo json_encode($driverHasVehicleDAO->disableDriver($iddriver));
        break;
}
