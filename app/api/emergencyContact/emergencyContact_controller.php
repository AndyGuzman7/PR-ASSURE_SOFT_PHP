<?php
require 'emergencyContact_dao.php';
require 'emergencyContact_parser.php';

header("Content-Type: application/json");
$requestMethod = $_SERVER['REQUEST_METHOD'];
$emergencyContactDao = new EmergencyContactDAO();
$parser = new EmergencyContactParser();


switch($requestMethod) {
    case 'GET':
        $idclientuser = $_GET['idClientUser'];
        echo json_encode($emergencyContactDao->getEmergencyContactsById($idclientuser));
        break;
    case 'POST':
        $json = json_decode(file_get_contents("php://input"), true);
        $emergencyContact =$parser->parse($json);
        echo json_encode($emergencyContactDao->insert($emergencyContact));
        break;
    case 'PUT':
        $json = json_decode(file_get_contents("php://input"),true);
        $emergencyContact =$parser->parse($json);

        echo json_encode($emergencyContactDao->update($emergencyContact));
        break;
    case 'DELETE':
        $json = json_decode(file_get_contents("php://input"),true);
        $emergencyContact =$parser->parse($json);
        echo json_encode($emergencyContactDao->delete($emergencyContact));
        break;
}