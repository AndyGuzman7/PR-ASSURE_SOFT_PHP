<?php
/**
 * Controller for Driver related requests  
 * 
 * Selects the correct method to execute according to http request method
 * using Driver DAO (Data Access Object).
 * 
 * @see Driver\DriverDAO
 * @author Sofia Valeria Toro Chambi
 */

/**Processes requests received making use of queries */
require_once 'driver_dao.php';
require_once 'driver_parser.php';

header("Content-Type: application/json");
$requestMethod = $_SERVER['REQUEST_METHOD'];
$driverDAO = new DriverDAO();
$parser = new DriverParser();

switch($requestMethod) {
    case 'GET':
        if (!empty($_GET['ownerId'])) {
            $ownerId  = $_GET['ownerId'];
            if (!empty($_GET['criteria'])) {
                echo json_encode($driverDAO->getDriversByNameOrCi($_GET['criteria'], $ownerId));
            }
            else {
                echo json_encode($driverDAO->getDriversByOwner($ownerId));
            }
            ///ESTA ES
        }
        break;
    case 'POST':
        $jsonDriver = json_decode(file_get_contents("php://input"), true);
        $driver = $parser->parse($jsonDriver);
        echo json_encode($driverDAO->insert($driver));
        break;
    case 'PUT':
        $jsonDriver = json_decode(file_get_contents("php://input"), true);
        $driver = $parser->parseUpdate($jsonDriver);
        echo json_encode($driverDAO->update($driver));
        break;
    case 'DELETE':
        $jsonDriver = json_decode(file_get_contents("php://input"), true);
        $iddriver = $jsonDriver['id'];
        echo json_encode($driverDAO->delete($iddriver));
        break;
}
