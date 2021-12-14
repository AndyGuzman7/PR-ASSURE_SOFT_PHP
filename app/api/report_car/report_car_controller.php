<?php
header("Content-Type: application/json");
require_once 'report_car_dao.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$reportCarDao = new ReportCarDAO();

switch($requestMethod) {
    case 'GET':
        if(!empty($_GET['idVehicle'])) {
            // obtencion de media de puntuacion
            $idVehicle = $_GET['idVehicle'];
            echo json_encode($reportCarDao->getStarsAverage($idVehicle));
        }
        if(!empty($_GET['idOwner']) && !empty($_GET['idVehicleOfOwner'])){
            echo json_encode($reportCarDao->getCommentsByVehicle($_GET['idOwner'],$_GET['idVehicleOfOwner']));
        }
        break;
    case 'POST':
        $jsonReportCar = file_get_contents('php://input');
        echo json_encode($reportCarDao->insert($jsonReportCar));
        break;
}