<?php
// require "../config.php";
require "../local_config.php";

$pdo = $db;
$fullname = $_POST['fullname'];
$cellphone = $_POST['cellphone'];
$email = $_POST['email'];
$password = $_POST['password'];
$address = $_POST['address'];
$ci = $_POST['ci'];
try {
  $pdo->beginTransaction();
  $insertSql = "
      INSERT INTO `person`
        (`fullname`,`cellphone`, `updateDate`)
      VALUES
        (:fullname, :cellphone, current_timestamp)
  ";
  $insertSql2 = "
      INSERT INTO `user`
        (`idUser`, `email`,`password`, `idrolUser` , `updateDate`)
      VALUES
        (:idUser, :email ,:password , 27, current_timestamp)
  ";
  $insertSql3 = "
      INSERT INTO `owner`
        (`idowner`, `address`, `ci`, `company_idcompany`)
      VALUES
        (:idowner, :address, :ci, 1)";
  $statement = $pdo->prepare($insertSql);
  $statement->execute(array(
    "fullname" => $fullname,
    "cellphone" => $cellphone,
  ));
  $idPerson = $pdo->lastInsertId();
  $idowner = $idPerson;
  $statement2 = $pdo->prepare($insertSql2);
  $statement2->execute(array(
    "idUser" => $idPerson,
    "email" => $email,
    "password" => $password,
  ));
  $statement3 = $pdo->prepare($insertSql3);
  $statement3->execute(array(
    "idowner" => $idowner,
    "address" => $address,
    "ci" => $ci,
  ));
  $pdo->commit();
  echo json_encode("Success");
} catch (\Exception $e) {
  $pdo->rollback();
  echo json_encode($e);
}