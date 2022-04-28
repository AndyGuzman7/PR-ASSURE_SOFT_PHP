<?php
require_once 'auth_driver_dao.php';
require_once '../user/user_parser.php';

header("Content-Type: application/json");
ini_set("allow_url_fopen", true);
$requestMethod = $_SERVER['REQUEST_METHOD'];
//$parser = new UserParser();
$authDriverDao = new AuthDriverDAO();

switch($requestMethod) {
	case 'GET':
		$username = $_GET['username'];
		$password = $_GET['password'];
		$authDriverDao->logInDriver($username, $password);
		break;
	
}