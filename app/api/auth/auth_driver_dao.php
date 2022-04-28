<?php
require_once '../codes.php';
require_once '../local_config.php';
require_once '../driver/driver.php';

class AuthDriverDAO {
    private $pdo;

    public function __construct()
    {
        $this->pdo = DBConnection::GetConnection();
    }

    public function logInDriver($email, $password) {
        $queryEmail = "SELECT * FROM `driver` WHERE email = :email;";
		$paramsEmail = ['email' => $email];

		

        $queryUserDriver = "SELECT D.iddriver AS 'id', P.fullName AS 'name', D.role AS 'role', P.cellphone AS 'cellphone' 
                            FROM driver D
                            INNER JOIN person P ON P.idPerson = D.iddriver
                            WHERE D.email = :email AND D.password = MD5(:password) AND D.status = 1;";
        $paramsUser = [
            'email'=>$email,
            'password'=>$password
        ];
		try {
			$stmtEmail = $this->pdo->prepare($queryEmail);
			$stmtEmail->execute($paramsEmail);
			$emailCount = count($stmtEmail->fetchAll());

			if($emailCount > 0) {
				$stmtUser = $this->pdo->prepare($queryUserDriver);
				$stmtUser->execute($paramsUser);
				$result = $stmtUser->fetch();
				if($result) {
					echo json_encode($result);
				}
				else {
					http_response_code(401);
					echo json_encode("incorrect password");
				}
			}
			else {
				http_response_code(401);
				echo json_encode("Conductor no Existe");
			}
		}
		catch (Exception $e) {
			http_response_code(503);
			echo json_encode($e);
		}
    }
}