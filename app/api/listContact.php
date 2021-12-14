<?php

require "config.php";
$idcliente = $_POST['idcliente'];

try {
	$query = "SELECT idEmergencyContact, nameContact, number
		FROM emergencycontact
		WHERE clientuser_idclientuser = :idcliente";
	$params = [ 'idcliente' => $idcliente ];
	
	$statement = $db->prepare($query);
	$statement->execute($params);
	$count = $statement->rowCount();
	if($count > 0) {
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($results);
	}
	else {
		echo json_encode("Error");
	}
}
catch (Exception $e) {
	echo json_encode("Error: ".$e->getMessage());
}
