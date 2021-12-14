<?php

/**
 * Data Access Object for Company table
 * 
 * Processes sql statements to access/manipulate driver
 * table on database and related.
 * 
 * @author Fabricio Rene Crespo Rossel
 */

// require '../config.php';
require_once '../local_config.php';
require 'company.php';

class CompanyDAO
{
    private $pdo;

    public function __construct() {
        $this->pdo = \DBConnection::GetConnection();
    }

    public function getCompanyByCriteria($valueSearch) {
        $query = "SELECT idCompany, name, state, NIT
        FROM company
        WHERE name LIKE :valueSearchOne OR NIT LIKE :valueSearchTwo";

        $params = [
            'valueSearchOne' =>"%".$valueSearch."%",
            'valueSearchTwo' => "%".$valueSearch."%",
        ];

        $result = $this->pdo->prepare($query);
        $result->execute($params);
        return $this->getCompaniesAsArray($result);
    }

    /**
     * Inserts data into table Company
     * through a query which params are sent by user
     */
    public function insert($jsonCompany) {
        $companyArray = json_decode($jsonCompany, true);
        $company = new Company(
            0,
            $companyArray['name'],
            $companyArray['nit'],
            1
        );

        $query = "INSERT INTO company(name, `NIT`, state) VALUES (:name, :nit, 1)";
        $params = [
            "name" => $company->name,
            "nit" => $company->nit,
        ];

        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            return "success";
        }
        catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    /**
     * Updates table Company on fields 
     * name, NIT and state through a query 
     */
    public function update($jsonCompany) {
        $companyArray = json_decode($jsonCompany, true);
        $company = new Company(
            $companyArray['id'],
            $companyArray['name'],
            $companyArray['nit'],
            $companyArray['status']
        );
        $query = "UPDATE company SET
                name = :name,
                `NIT` = :nit,
                state = :status
            WHERE idCompany = :id";
        $params = [
            "name" => $company->name,
            "nit" => $company->nit,
            "status" => $company->status,
            "id" => $company->id
        ];
        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            return "success";

        } catch (Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    public function getCompanies() {
        $query = "SELECT idCompany, name, state, NIT
        FROM company";
        
        $result = $this->pdo->query($query);
        return $this->getCompaniesAsArray($result);
    }

    public function getCompaniesByCriteria($valueSearch) {
        $query = "SELECT idCompany, name, state, NIT
        FROM company
        WHERE name LIKE :valueSearchOne OR NIT LIKE :valueSearchTwo";

        $params = [
            'valueSearchOne' =>"%".$valueSearch."%",
            'valueSearchTwo' => "%".$valueSearch."%",
        ];

        try {
            $result = $this->pdo->prepare($query);
            $result->execute($params);
            return $this->getCompaniesAsArray($result);
        }
        catch(Exception $e) {
            http_response_code(503);
            return $e;
        }
    }

    private function getCompaniesAsArray($queryResult) {
        $company = [];

        while ($row = $queryResult->fetch()) {
            array_push($company, new Company(
                $row['idCompany'],
                $row['name'],
                $row['NIT'],
                $row['state'],
            ));
        }
        return $company;
    }
}
