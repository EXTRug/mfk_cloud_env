<?php

namespace OCA\MFKDashboard\Service;

use OCA\MFKDashboard\Utils\DesignHelper;

use OCP\ILogger;

class DatabaseService
{
    private $pdo;

    public function __construct()
    {
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

    public function getPdo()
    {
        return $this->pdo;
    }


    public function getCompanies(array $fields, array $filters = [])
    {
        $allowedFields = ['companyID', 'name', 'satisfaction'];

        $filteredFields = array_intersect($fields, $allowedFields);

        if (empty($filteredFields)) {
            return null;
        }

        $filterSQL = "";
        $useFilter = false;
        if ($filters["searchTerm"] != "") {
            $filterSQL .= ' name LIKE "%' . $filters["searchTerm"] . '%" and ';
            $useFilter = true;
        }
        if ($filters["onlyActive"] != null) {
            $filterSQL .= ' (status = "active" or status = "In preparation") and ';
            $useFilter = true;
        }
        if ($useFilter) {
            for ($i = 0; $i < count($filteredFields); $i++) {
                $filteredFields[$i] = "c." . $filteredFields[$i];
            }
            $fieldsList = implode(", ", $filteredFields);
            $stmt = $this->pdo->prepare("SELECT DISTINCT $fieldsList FROM companies.company c INNER JOIN companies.jobs j ON c.companyID = j.company WHERE " . substr($filterSQL, 0, -4));
        } else {
            $fieldsList = implode(", ", $filteredFields);
            $stmt = $this->pdo->prepare("SELECT $fieldsList FROM companies.company");
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getJobsList(array $fields, array $filters = [])
    {
        $allowedFields = ['funnel_name', 'id'];

        $filteredFields = array_intersect($fields, $allowedFields);

        if (empty($filteredFields)) {
            return null;
        }

        $fieldsList = implode(", ", $filteredFields);
        if ($filters["searchTerm"] != "") {
            $stmt = $this->pdo->prepare('SELECT ' . $fieldsList . ' FROM companies.jobs WHERE funnel_name LIKE "%' . $filters["searchTerm"] . '%" AND status="active"');
        } else {
            $stmt = $this->pdo->prepare('SELECT ' . $fieldsList . ' FROM companies.jobs WHERE status="archieved"');
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTopBewerber(array $fields, $funnel, $count = 3)
    {
        $allowedFields = ['firstname', 'lastname', 'progress.score', 'cv', 'joined', 'email'];

        $filteredFields = array_intersect($fields, $allowedFields);

        if (empty($filteredFields)) {
            return null;
        }

        $fieldsList = implode(", ", $filteredFields);
        $stmt = $this->pdo->prepare('SELECT ' . $fieldsList . ' FROM applicants.applicant JOIN applicants.progress ON applicants.applicant.email = applicants.progress.applicant WHERE job="' . $funnel . '" ORDER BY progress.score LIMIT ' . $count);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCallHistory($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM companies.kbCalls WHERE job = ' . $id . " ORDER BY timestamp DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCompany(array $fields, int $id)
    {
        $allowedFields = ['companyID', 'name', 'jobs', 'website', 'satisfaction', 'manager'];

        $filteredFields = array_intersect($fields, $allowedFields);

        if (empty($filteredFields)) {
            return null;
        }

        $fieldsList = implode(", ", $filteredFields);

        $stmt = $this->pdo->prepare("SELECT $fieldsList FROM companies.company WHERE companyID = ?");
        $stmt->execute(array($id));
        return $stmt->fetchAll()[0];
    }

    public function getCompanyJobs(array $fields, int $companyID, array $filters = [], bool $assignColor = false)
    {
        $allowedFields = ['title', 'id', 'status'];
        $filteredFields = array_intersect($fields, $allowedFields);

        if (empty($filteredFields)) {
            return null;
        }

        $fieldsList = implode(", ", $filteredFields);

        if ($filters != []) {
            $queryFilters = "";
            if ($filters["searchTerm"] != "") {
                $queryFilters .= 'and title LIKE "%' . $filters["searchTerm"] . '%"';
            }
            $stmt = $this->pdo->prepare("SELECT $fieldsList FROM companies.jobs WHERE company = ? " . $queryFilters);
        } else {
            $stmt = $this->pdo->prepare("SELECT $fieldsList FROM companies.jobs WHERE company = ?");
        }

        $stmt->execute(array($companyID));
        if ($assignColor) {
            $result = $stmt->fetchAll();
            foreach ($result as $key => &$job) {
                $job["color"] = DesignHelper::getStatusColor($job["status"]);
            }
            return $result;
        } else {
            return $stmt->fetchAll();
        }
    }

    public function getJob(array $fields, int $id)
    {
        $allowedFields = [
            "title",
            "id",
            "funnel_name",
            "company",
            "status",
            "location",
            "campaign",
            "duration",
            "funnel_url",
            "salary_range",
            "customerInput",
            "manager",
            "internalNote",
            "scheduledCustomerVisit",
            "campaign",
            "salary_range",
            "asp",
            "jobFolder"
        ];

        $filteredFields = array_intersect($fields, $allowedFields);

        if (empty($filteredFields)) {
            return null;
        }

        $fieldsList = implode(", ", $filteredFields);

        $stmt = $this->pdo->prepare("SELECT $fieldsList FROM companies.jobs WHERE id = ?");
        $stmt->execute(array($id));
        $response = $stmt->fetchAll()[0];

        if (in_array("history", $fields)) {
            $response["history"] = $this->getJobHistory($id);
        }
        return $response;
    }

    public function getApplicant(array $fields, string $email, string $funnel_name)
    {
        $allowedFields = ["firstname", "lastname", "cv", "joined", "interviewQS"];
        $applicantTableFields = ["firstname", "lastname", "cv"];
        $progressTableFields = ["joined", "interviewQS"];

        $filteredFields = array_intersect($fields, $allowedFields);
        $applicantFields = array_intersect($filteredFields, $applicantTableFields);
        $progressFields = array_intersect($filteredFields, $progressTableFields);

        $applicantFields = implode(", ", $applicantFields);
        $progressFields = implode(", ", $progressFields);

        $response = array("applicant" => null, "proress" => null);

        $stmt = $this->pdo->prepare("SELECT $applicantFields FROM applicants.applicant WHERE email = ?");
        $stmt->execute(array($email));
        $response["applicant"] = $stmt->fetchAll()[0];

        $stmt = $this->pdo->prepare("SELECT $progressFields FROM applicants.progress WHERE applicant = ? and job = ?");
        $stmt->execute(array($email, $funnel_name));
        $response["progress"] = $stmt->fetchAll()[0];

        return $response;
    }

    public function saveEvent(int $job, $title): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO companies.history (title, job) VALUES (?,?)");
        if ($stmt->execute(array($title, $job))) {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function changeCompanySatisfaction(int $company, int $satisfaction): bool
    {
        // TO DO: check satisfaction range.
        $stmt = $this->pdo->prepare("UPDATE companies.company SET satisfaction = ? WHERE companyID = ?");
        if ($stmt->execute(array($satisfaction, $company))) {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function logNewKBCall(int $job, $selection)
    {
        $stmt = $this->pdo->prepare("INSERT INTO companies.kbCalls (job, upsellPitched, upsellSold, testimonialPitched, testimonialSold, recommendationPitched, recommendationSold, crossSellPitched, crossSellSold) VALUES (?,?,?,?,?,?,?,?,?)");
        if ($stmt->execute(array($job, $selection["upsell"][0], $selection["upsell"][1], $selection["testimonial"][0], $selection["testimonial"][1], $selection["recommendation"][0], $selection["recommendation"][1], $selection["crossSell"][0], $selection["crossSell"][1]))) {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function changeJobNotification(int $job, string $manager, string $mode)
    {
        $managerDB = json_decode($this->getJob(["manager"], $job)["manager"]);
        if ($mode == "on") {
            array_push($managerDB->manager, $manager);
        } else {
            $match = -1;
            for ($i = 0; $i < count($managerDB->manager); $i++) {
                echo ($managerDB->manager[$i] . "\n");
                if ($managerDB->manager[$i] === $manager) {
                    $match = $i;
                    break;
                }
            }
            unset($managerDB->manager[$match]);
            $managerDB->manager = array_values($managerDB->manager);
        }
        $stmt = $this->pdo->prepare("UPDATE companies.jobs SET manager = ? WHERE id = ?");
        if ($stmt->execute(array(json_encode($managerDB), $job))) {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function updateJobNote(int $job, string $note)
    {
        $stmt = $this->pdo->prepare("UPDATE companies.jobs SET internalNote = ? WHERE id = ?");
        if ($stmt->execute(array($note, $job))) {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function updateJobCustomerVisit(int $job, string $date)
    {
        $stmt = $this->pdo->prepare("UPDATE companies.jobs SET scheduledCustomerVisit = ? WHERE id = ?");
        if ($stmt->execute(array($date, $job))) {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function updateJobData(int $job, array $data): bool
    {
        $jobData = $this->getJob(["campaign", "salary_range", "location"], $job);
        // update Job campaign field
        if ($jobData["campaign"] != null && $jobData["campaign"] != "{}") {
            $campaign = json_decode($jobData["campaign"], true);
        } else {
            $campaign = array();
        }
        $campaign["title"] = $data["title"];
        $campaign["ebay"] = array(
            "job" => $data["ebay1"],
            "sub_category" => $data["ebay2"]
        );
        // campaign media
        $campaign["benefits"] = $data["benefits"];
        $campaign["desc_job"] = $data["descProf"];
        $campaign["display_text"] = $data["descSoc"];

        // update salary_range
        if ($jobData["salary_range"] != null && $jobData["salary_range"] != "{}") {
            $salaryRange = json_decode($jobData["salary_range"], true);
        } else {
            $salaryRange = array();
        }
        $salaryRange["stop"] = $data["salaryMax"];
        $salaryRange["start"] = $data["salaryMin"];

        // update location  //TODO: location query
        if ($jobData["location"] != null && $jobData["location"] != "[]") {
            $location = json_decode($jobData["location"], true);
        } else {
            $location = array(array());
        }
        if ($data["plz"] != "") {
            try {
            } catch (\Throwable $th) {
            }
            $locationRequest = json_decode(file_get_contents("https://openplzapi.org/de/Localities?postalCode=" . $data["plz"], false), true);
            $chosen = null;
            if (count($locationRequest) > 1) {
                foreach ($locationRequest as $key => $l) {
                    if (!str_contains("unbewohnt", $l["municipality"]["type"])) {
                        $chosen = $l;
                    }
                }
            } else {
                $chosen = $locationRequest[0];
            }
            $location[0]["plz"] = $chosen["postalCode"];
            $location[0]["city"] = $chosen["name"];
            $location[0]["region"] = $chosen["district"]["name"];
            $location[0]["country"] = "DE";
        }
        $stmt = $this->pdo->prepare("UPDATE companies.jobs SET campaign = ?, location = ?, salary_range = ?, asp = ?, funnel_url = ? WHERE id = ?;");
        if ($stmt->execute(array(json_encode($campaign), json_encode($location), json_encode($salaryRange), $data["asp"], $data["link"], $job))) {
            if ($stmt->rowCount() > 0) {
                return true;
            }
        }
        return false;
    }

    private function getJobHistory(int $job)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM companies.history WHERE job = ? ORDER BY timestamp DESC");
        $stmt->execute(array($job));
        return $stmt->fetchAll();
    }

    public function toggleJobStatus(int $job, bool $active): bool
    {
        $stmt = $this->pdo->prepare("UPDATE companies.jobs SET status = ? WHERE id = ?");
        if ($active) {
            $resp = $stmt->execute(array("active", $job));
        } else {
            $resp = $stmt->execute(array("archieved", $job));
        }
        if ($resp) {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
