<?php
require_once 'auth_dao.php';
require_once '../user/user_parser.php';

header("Content-Type: application/json");
ini_set("allow_url_fopen", true);
$requestMethod = $_SERVER['REQUEST_METHOD'];
$parser = new UserParser();
$authDao = new AuthDAO();

switch($requestMethod) {
	case 'GET':
		$email = $_GET['email'];
		$password = $_GET['password'];
		$authDao->logIn($email, $password);
		break;
	case 'POST':
		$jsonUser = json_decode(file_get_contents("php://input"), true);
        $user = $parser->parse($jsonUser);
		$authDao->signUpClient($user);
		break;
}
