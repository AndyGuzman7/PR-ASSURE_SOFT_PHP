<?php
/**
 * @author Yhonattan David Llanos Rivera
 */

require_once 'user_dao.php';
require_once 'user_parser.php';

header("Content-Type: application/json");
$requestMethod = $_SERVER['REQUEST_METHOD'];
$userDao = new UserDAO();
$parser = new UserParser();

switch($requestMethod){
    case 'GET':
        if(!empty($_GET['email'])) {
            $email = $_GET['email'];
            $expectedResponse = $_GET['expectedResponse'];
            if ($expectedResponse == "cellphone") {
                echo json_encode(['result'=>$userDao->getPhoneByEmail($email)]);
            }
            else if ($expectedResponse == "id") {
                echo json_encode($userDao->getIdByEmail($email));
            }
        }else if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $expectedResponse = $_GET['expectedResponse'];
            if ($expectedResponse == "listNumberCellphone"){
                echo json_encode(['result'=>$userDao->getEmergencyContactsById($id)]);
            }
            else if ($expectedResponse == "clientUser") {
                echo json_encode(['result'=>$userDao->getClientUserById($id)]);
            }
        }
        break;
    case 'PUT':
        $jsonUser = json_decode(file_get_contents("php://input"),true);
        if(!empty($jsonUser['password'])) {
            echo json_encode(['result'=>$userDao->updatePassword($jsonUser['email'],$jsonUser['password'])]);
        }
        else {
            // echo json_encode(['result'=>$userDao->updateUser($jsonUser)]);
        }
        break;

    }
