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

    
    public function getCompanies(array $fields) {
        $allowedFields = ['companyID', 'name'];
    
        $filteredFields = array_intersect($fields, $allowedFields);
    
        if (empty($filteredFields)) {
            return null;
        }
    
        $fieldsList = implode(", ", $filteredFields);
    
        $stmt = $this->pdo->prepare("SELECT $fieldsList FROM companies.company");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCompany(array $fields, int $id) {
        $allowedFields = ['companyID', 'name', 'jobs'];
    
        $filteredFields = array_intersect($fields, $allowedFields);
    
        if (empty($filteredFields)) {
            return null;
        }
    
        $fieldsList = implode(", ", $filteredFields);
    
        $stmt = $this->pdo->prepare("SELECT $fieldsList FROM companies.company WHERE companyID = ?");
        $stmt->execute(array($id));
        return $stmt->fetchAll()[0];
    }

    public function getCompanyJobs(array $fields, int $companyID) {
        $allowedFields = ['title', 'id', 'status'];
    
        $filteredFields = array_intersect($fields, $allowedFields);
    
        if (empty($filteredFields)) {
            return null;
        }
    
        $fieldsList = implode(", ", $filteredFields);
    
        $stmt = $this->pdo->prepare("SELECT $fieldsList FROM companies.jobs WHERE company = ?");
        $stmt->execute(array($companyID));
        return $stmt->fetchAll();
    }
    
}