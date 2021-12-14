<?php
header("Content-Type: application/json");
require 'historyReview_dao.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$historyReviewDao = new HistoryReviewDAO();

switch($requestMethod) {
    case 'GET':
        if(!empty($_GET['userId'])) {
            echo json_encode($historyReviewDao->getHistoryReviewByUser($_GET['userId']));
        }
    break;
}