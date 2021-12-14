<?php

/**
 * Controller for Driver related requests  
 * 
 * Selects the correct method to execute according to http request method
 * using Driver DAO (Data Access Object).
 * 
 * @see Company\CompanyDAO
 * @author Fabricio Rene Crespo Rossel
 */


header("Content-Type: application/json");
require 'company_dao.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$companyDao = new CompanyDAO();

switch ($requestMethod) {
    case 'GET':
        if(!empty($_GET['criteria'])) {
            echo json_encode($companyDao->getCompaniesByCriteria($_GET['criteria']));
        } else {
            echo json_encode($companyDao->getCompanies());
        }
        break;
    case 'POST':
        $jsonCompany = file_get_contents('php://input');
        echo json_encode($companyDao->insert($jsonCompany));
        break;
    case 'PUT':
        $jsonCompany = file_get_contents('php://input');
        echo json_encode($companyDao->update($jsonCompany));
        break;
}
