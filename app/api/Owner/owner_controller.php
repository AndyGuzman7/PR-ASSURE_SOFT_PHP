<?php

require_once 'owner_dao.php';
require_once 'owner_parser.php';

header("Content-Type: application/json");
$requestMethod = $_SERVER['REQUEST_METHOD'];
$ownerDAO = new OwnerDAO();
$parser = new OwnerParser();

switch ($requestMethod) {
    case 'GET':
        if(!empty($_GET['criteria'])) {
            echo json_encode($ownerDAO->getOwnerByNameCiOrPhone($_GET['criteria']));
        } else if (!empty($_GET['ownerId'])) {
            echo json_encode($ownerDAO->getOwnerById($_GET['ownerId']));
        } 
        else {
            echo json_encode($ownerDAO->getOwners());
        }
        break;
    case 'PUT':
        $jsonOwner = json_decode(file_get_contents("php://input"), true);
        $owner = new Owner(
            $jsonOwner['id'],
            $jsonOwner['fullName'],
            $jsonOwner['phone'],
            $jsonOwner['email'],
            $jsonOwner['password'],
            $jsonOwner['address'],
            $jsonOwner['ci'],
            $jsonOwner['idCompany'],
            $jsonOwner['status']
        );
        echo json_encode($ownerDAO->update($owner));
        break;
    case 'POST':
        $jsonOwner = json_decode(file_get_contents("php://input"), true);
        $owner = $parser->parse($jsonOwner);
        echo json_encode($ownerDAO->save($owner));
        break;
    case 'DELETE':
        $jsonOwner = json_decode(file_get_contents("php://input"), true);
        $idowner = $jsonOwner['id'];
        echo json_encode(['result' => $ownerDAO->delete($idowner)]);
        break;
}
