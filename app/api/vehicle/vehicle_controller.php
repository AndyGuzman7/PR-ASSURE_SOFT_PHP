<?php
header("Content-Type: application/json");
require_once 'vehicle_dao.php';
require_once 'vehicle_parser.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$vehicleDAO = new VehicleDAO();
$parser = new VehicleParser();

switch ($requestMethod) {
    case 'GET':
        if(!empty($_GET['ownerId'])) {
            $ownerId = $_GET['ownerId'];
            echo json_encode($vehicleDAO->getVehiclesByOwner($ownerId));
        }
        else {
            echo json_encode($vehicleDAO->getAll());
        }
        break;
    case 'PUT':
        $jsonVehicle = json_decode(file_get_contents("php://input", "r"), true);
        $vehicle = new Vehicle(
            $jsonVehicle['idVehicle'],
            $jsonVehicle['color'],
            $jsonVehicle['model'],
            $jsonVehicle['pleik'],
            $jsonVehicle['capacity'],
            $jsonVehicle['photo'],
            $jsonVehicle['owner_idowner'],
            $jsonVehicle['status'],
        );
        echo json_encode(['result' => $vehicleDAO->updateVehicle($vehicle)]);
    break;
    case 'POST':
        $jsonVehicle = json_decode(file_get_contents("php://input"), true);
        $vehicle = $parser->parse($jsonVehicle);
        echo json_encode($vehicleDAO->insertVehicle($vehicle));
        break;
}
