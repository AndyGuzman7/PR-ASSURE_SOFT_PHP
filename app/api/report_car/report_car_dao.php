<?php
require_once '../local_config.php';
require_once 'report_car.php';
require_once '../user/user.php';

class ReportCarDAO {
    private $pdo;
    
    public function __construct() {
        $this->pdo = DBConnection::GetConnection();
    }


    public function insert($jsonCarReport) {
        $carReportArray = json_decode($jsonCarReport, true);
        $carReport = new CarReport(
            0,
            $carReportArray['calification'],
            $carReportArray['coments'],
            null,
            $carReportArray['clientUserId'],
            $carReportArray['vehicleId'],
        );

        $query = "INSERT INTO report_car(calification, coments, datetime, clientuser_idclientuser, vehicle_id)
        VALUES(:calification, :coments, CURRENT_TIMESTAMP, :clientUserId, :vehicleId)";

        $params = [
            "calification" => $carReport->calification,
            "coments" => $carReport->coments,
            "clientUserId" => $carReport->clientUserId,
            "vehicleId" => $carReport->vehicleId,
        ];

        try {
            $statement = $this->pdo->prepare($query);
            $res = $statement->execute($params);
            if($res) {
                return "success";
            }

            http_response_code(503);
            return "unable to insert review";

        } catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    public function getStarsAverage($idVehicle) {
	$query = "SELECT IFNULL(AVG(calification), 0) AS 'average' FROM report_car WHERE vehicle_id = :idVehicle";
        $params = ["idVehicle" => $idVehicle];

        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            $avg = $statement->fetch()['average'];

            return $avg;

        } catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    public function getCommentsByVehicle($ownerId, $vehicleId) {
        $query = "SELECT
            R.idReports AS 'id',
            R.calification AS 'calification',
            coments AS 'comment',
            datetime AS 'createdAt',
            R.vehicle_id AS 'vehicleId',
            V.owner_idowner AS 'ownerId',
            P.idPerson AS 'userId',
            P.fullName AS 'fullname',
            P.cellphone AS 'cellphone',
            U.email AS 'email'
        FROM report_car R
        INNER JOIN clientuser C ON C.idclientuser = R.clientuser_idclientuser
        INNER JOIN user U ON U.iduser = C.idclientuser
        INNER JOIN person P ON P.idPerson = U.iduser
        INNER JOIN vehicle V ON V.idVehicle = R.vehicle_id
        INNER JOIN owner O ON O.idOwner  = V.owner_idowner
        WHERE V.owner_idowner = :ownerId AND R.vehicle_id = :vehicleId";

        $params = [
            'ownerId' => $ownerId,
            'vehicleId' => $vehicleId
        ];

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            
            $comments = [];

            while ($row = $stmt->fetch()) {
                array_push($comments, [
                    'comment' => new CarReport(
                        $row['id'],
                        $row['calification'],
                        $row['comment'],
                        $row['createdAt'],
                        $row['userId'],
                        $row['vehicleId']
                    ),
                    'user' => new User(
                        $row['email'],
                        null,
                        null,
                        $row['userId'],
                        $row['fullname'],
                        $row['cellphone'],
                        null,
                        null,
                        null
                    )
                ]);
            }
            return $comments;
        }
        catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }
}
