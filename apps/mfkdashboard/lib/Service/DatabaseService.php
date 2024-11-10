<?php
namespace OCA\MFKDashboard\Service;

class DatabaseService {
    private $pdo;

    public function __construct() {
        // RDS Verbindungsdetails
        $host = 'your-rds-endpoint.amazonaws.com';
        $db = 'your_database_name';
        $user = 'your_db_user';
        $pass = 'your_db_password';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        // try {
        //     $this->pdo = new \PDO($dsn, $user, $pass, $options);
        // } catch (\PDOException $e) {
        //     throw new \Exception('Verbindung zur Datenbank fehlgeschlagen: ' . $e->getMessage());
        // }
    }

    public function getPdo() {
        return $this->pdo;
    }

    // Beispiel-Methode zum Abrufen von Daten
    public function fetchData($query, $params = []) {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}