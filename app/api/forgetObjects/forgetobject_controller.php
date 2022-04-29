<?php
    header("Content-Type: application/json");
    require 'forgetobject_dao.php';
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $objectDAO = new ForgetObjectsDAO();
    
    switch ($requestMethod) {
        case 'GET':
                echo json_encode($objectDAO->findObjects());
            break;

        case 'POST':
                $jsonObjects = json_decode(file_get_contents("php://input"), true);
                $objects = new forgetObject(
                    $jsonObjects['nameObject'],
                    $jsonObjects['description'],
                    $jsonObjects['Vehicle_idVehicle'],
                    $jsonObjects['clientuser_idclientuser']
                );
                echo json_encode(['result' => $objectDAO->saveObjects($objects)]);
                break;
        case 'DELETE':
            $a = json_decode(file_get_contents("php://input"), true);
            $idForgetObject = $a['idForgetObject'];
            echo json_encode(['result' => $objectDAO->delete($idForgetObject)]);
            break;
}