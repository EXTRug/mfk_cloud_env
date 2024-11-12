<?php
namespace OCA\MFKDashboard\Service;

class DatabaseService {
    private $pdo;

    public function __construct() {
        // RDS Verbindungsdetails
        $host = 'meinefachkraft.cluster-ce31lmrjui2s.eu-central-1.rds.amazonaws.com';
        $user = 'admin';
        $pass = 'uqO4x{[p5qnlbr|khy8D)2b$L5vr';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;charset=$charset";
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new \PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \Exception('Verbindung zur Datenbank fehlgeschlagen: ' . $e->getMessage());
        }
        //var_dump($this->getCompanies(["name"]));
    }

    public function getPdo() {
        return $this->pdo;
    }

    
    public function getCompanies(array $fields, array $filters=[]) {
        $allowedFields = ['companyID', 'name'];
    
        $filteredFields = array_intersect($fields, $allowedFields);
    
        if (empty($filteredFields)) {
            return null;
        }
    
        $fieldsList = implode(", ", $filteredFields);
        if($filters["searchTerm"] != ""){
            $stmt = $this->pdo->prepare('SELECT '.$fieldsList.' FROM companies.company WHERE name LIKE "%'.$filters["searchTerm"].'%"');
        }else{
            $stmt = $this->pdo->prepare("SELECT $fieldsList FROM companies.company");
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCompany(array $fields, int $id) {
        $allowedFields = ['companyID', 'name', 'jobs', 'website'];
    
        $filteredFields = array_intersect($fields, $allowedFields);
    
        if (empty($filteredFields)) {
            return null;
        }
    
        $fieldsList = implode(", ", $filteredFields);
    
        $stmt = $this->pdo->prepare("SELECT $fieldsList FROM companies.company WHERE companyID = ?");
        $stmt->execute(array($id));
        return $stmt->fetchAll()[0];
    }

    public function getCompanyJobs(array $fields, int $companyID, array $filters=[]) {
        $allowedFields = ['title', 'id', 'status'];
    
        $filteredFields = array_intersect($fields, $allowedFields);
    
        if (empty($filteredFields)) {
            return null;
        }
    
        $fieldsList = implode(", ", $filteredFields);

        if($filters != []){
            $queryFilters = "";
            if($filters["searchTerm"] != ""){
                $queryFilters .= 'and title LIKE "%'.$filters["searchTerm"].'%"';
            }
            $stmt = $this->pdo->prepare("SELECT $fieldsList FROM companies.jobs WHERE company = ? ".$queryFilters);
        }else{
            $stmt = $this->pdo->prepare("SELECT $fieldsList FROM companies.jobs WHERE company = ?");
        }
    
        $stmt->execute(array($companyID));
        return $stmt->fetchAll();
    }

    public function getJob(array $fields, int $id) {
        $allowedFields = ["title","id", "funnel_name", "company", "status", "location", "campaign"];
    
        $filteredFields = array_intersect($fields, $allowedFields);
    
        if (empty($filteredFields)) {
            return null;
        }
    
        $fieldsList = implode(", ", $filteredFields);
    
        $stmt = $this->pdo->prepare("SELECT $fieldsList FROM companies.jobs WHERE id = ?");
        $stmt->execute(array($id));
        return $stmt->fetchAll()[0];
    }

    public function getApplicant(array $fields, string $email, string $funnel_name) {
        $allowedFields = ["firstname","lastname", "cv", "joined", "interviewQS"];
        $applicantTableFields = ["firstname","lastname", "cv"];
        $progressTableFields = ["joined", "interviewQS"];
    
        $filteredFields = array_intersect($fields, $allowedFields);
        $applicantFields = array_intersect($filteredFields, $applicantTableFields);
        $progressFields = array_intersect($filteredFields, $progressTableFields);
    
        $applicantFields = implode(", ", $applicantFields);
        $progressFields = implode(", ", $progressFields);

        $response = array("applicant"=>null, "proress"=>null);
    
        $stmt = $this->pdo->prepare("SELECT $applicantFields FROM applicants.applicant WHERE email = ?");
        $stmt->execute(array($email));
        $response["applicant"] = $stmt->fetchAll()[0];

        $stmt = $this->pdo->prepare("SELECT $progressFields FROM applicants.progress WHERE applicant = ? and job = ?");
        $stmt->execute(array($email, $funnel_name));
        $response["progress"] = $stmt->fetchAll()[0];

        return $response;
    }
    
}