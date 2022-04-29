<?php
require_once '../codes.php';
require_once '../local_config.php';
require_once '../user/user.php';

class AuthDAO {
    private $pdo;

    public function __construct()
    {
        $this->pdo = DBConnection::GetConnection();
    }

    public function logIn($email, $password) {
        $queryEmail = "SELECT * FROM `user` WHERE email = :email";
		$paramsEmail = ['email' => $email];

		$queryUser = "SELECT U.iduser AS 'id', P.fullName as 'name', RU.name as 'role', P.cellphone as 'cellphone'
			FROM user U
			INNER JOIN rolUser RU ON RU.idrolUser=U.idrolUser
			INNER JOIN person P on P.idPerson=U.iduser
			WHERE U.email = :email AND U.password = MD5(:password) AND U.status = 1";
		$paramsUser = [
			'email'=>$email,
			'password'=>$password
		];

		try {
			$stmtEmail = $this->pdo->prepare($queryEmail);
			$stmtEmail->execute($paramsEmail);
			$emailCount = count($stmtEmail->fetchAll());

			if($emailCount > 0) {
				$stmtUser = $this->pdo->prepare($queryUser);
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
				echo json_encode("user does not exists");
			}
		}
		catch (Exception $e) {
			http_response_code(503);
			echo json_encode($e);
		}
    }

    public function signUpClient(User $user) {
        $insertPerson = "INSERT INTO person (fullname, cellphone, updateDate)
			VALUES (:fullname, :cellphone, NOW())";
		$insertUser = "INSERT INTO `user`
			(idUser, email, `password`, idrolUser, updateDate)
			VALUES (:idUser,:email, MD5(:password), :idrolUser, NOW())";
		$insertClient = "INSERT INTO clientuser (idclientuser, resgister)
			VALUES (:idclientuser, :resgister)";
		
		$verifyEmail = $this->pdo->prepare("SELECT email FROM user WHERE email = :email");
		$verifyEmail->execute(['email' => $user->getEmail()]);
		if ($verifyEmail->fetch() == 0) {
			try {
			
				$this->pdo->beginTransaction();
				$stmtPerson = $this->pdo->prepare($insertPerson);
				$stmtPerson->execute(array(
					"fullname" => $user->getFullName(),
					"cellphone" => $user->getCellphone(),
				));
				$user->setIdPerson($this->pdo->lastInsertId());
				$stmtUser = $this->pdo->prepare($insertUser);
				$stmtUser->execute(array(
					"idUser" => $user->getIdPerson(),
					"email" => $user->getEmail(),
					"password" => $user->getPassword(),
					"idrolUser" => CLIENT_ROLE_CODE,
				));
				$stmtClient = $this->pdo->prepare($insertClient);
				$stmtClient->execute(array(
					"idclientuser" => $user->getIdPerson(),
					"resgister" => $user->getTypeRegister(),
				));
				
				$this->pdo->commit();
				echo json_encode("success");
				
			}
			catch (Exception $e) {
				$this->pdo->rollback();
				http_response_code(503);
				echo json_encode($e);
			}
		}
		else {
			http_response_code(401);
			echo json_encode("user already exists");
		}
    }
}