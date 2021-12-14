<?php
require_once '../local_config.php';
require_once 'historyReview.php';

class HistoryReviewDAO {
    private $pdo;
    
    public function __construct() {
        $this->pdo = DBConnection::GetConnection();
    }

    public function getHistoryReviewByUser($valueUser) {
        $query = "SELECT D.iddriver, R.clientuser_idclientuser AS 'idClientUser', R.calification, R.coments, R.datetime, P.fullName, D.photo, V.pleik
        FROM report_car R
        INNER JOIN vehicle V ON  R.vehicle_id = V.idVehicle  
        INNER JOIN driver_has_vehicle DV ON DV.vehicle_idVehicle = V.idVehicle
        INNER JOIN driver D ON D.iddriver =  DV.driver_iddriver
        INNER JOIN person P ON P.idPerson = D.idDriver
        WHERE R.clientuser_idclientuser = :valueUser";

        $params = [
            'valueUser' => $valueUser,
        ];

        $result = $this->pdo->prepare($query);
        $result->execute($params);
        return $this->getHistoryReviewArray($result);
    }

    private function getHistoryReviewArray($queryResult) {
        $company = [];

        while ($row = $queryResult->fetch()) {
            array_push($company, new HistoryReview(
                $row['iddriver'],
                $row['idClientUser'],
                $row['fullName'],
                $row['pleik'],
                $row['photo'],
                $row['coments'],
                $row['datetime'],
                $row['calification'],
            ));
        }
        return $company;
    }
}