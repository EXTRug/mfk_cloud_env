<?php

declare(strict_types=1);

namespace OCA\MFKDashboard\Controller;

use OCA\MFKDashboard\Service\DatabaseService;
use OCA\MFKDashboard\Service\FilesService;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\Attribute\ApiRoute;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\OCSController;
use OCP\IRequest;

class ApiController extends OCSController
{

    private DatabaseService $dbService;
    private FilesService $fileService;
    private $makeEndpoint;

    public function __construct(DatabaseService $dbService, IRequest $request, FilesService $fileService)
    {
        // Richtiges Aufrufen des Elternkonstruktors mit beiden Parametern
        parent::__construct('mfkdashboard', $request);
        $this->dbService = $dbService;
        $this->fileService = $fileService;
        $this->makeEndpoint = "https://hook.eu1.make.com/gi5eaftusy05b2dd2b8xph9rf5k2m9ax";
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'GET', url: 'api/queryCompanies')]
    public function queryCompanies(): DataResponse
    {
        $searchTerm = $_GET['searchTerm'] ?? '';
        $filterOnlyActive = $_GET['filterActive'] ?? '';

        $filters = array(
            "searchTerm" => $searchTerm,
            "onlyActive" => null
        );

        if ($filterOnlyActive == "true") {
            $filters["onlyActive"] = true;
        }

        $companies = $this->dbService->getCompanies(["companyID", "name", "satisfaction"], $filters);

        return new DataResponse(
            ["data" => json_encode($companies)],
            Http::STATUS_OK,
        );
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'GET', url: 'api/sendJobData')]
    public function sendJobData(): DataResponse
    {
        $email = $_GET['email'] ?? '';
        $id = $_GET['id'] ?? '';

        $data = ['email' => $email, 'job' => $id, 'action' => 'sendJobData'];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($this->makeEndpoint, false, $context);
        if ($result === false) {
            return new DataResponse(
                ["data" => "couldn't process request"],
                Http::STATUS_INTERNAL_SERVER_ERROR,
            );
        }
        return new DataResponse(
            ["data" => "ok"],
            Http::STATUS_OK,
        );
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'GET', url: 'api/requestCV')]
    public function requestCV(): DataResponse
    {
        $email = $_GET['email'] ?? '';
        $id = $_GET['id'] ?? '';

        $url = 'https://hook.eu1.make.com/sc76d4srs1hjapho4ead6w8ogoadgqn7';
        $data = ['email' => $email, 'job' => $this->dbService->getJob(["funnel_name"], intval($id))["funnel_name"]];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === false) {
            return new DataResponse(
                ["data" => "couldn't process request"],
                Http::STATUS_INTERNAL_SERVER_ERROR,
            );
        }
        return new DataResponse(
            ["data" => "ok"],
            Http::STATUS_OK,
        );
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'POST', url: 'api/logCall')]
    public function logCall(): DataResponse
    {
        $url = 'https://hook.eu1.make.com/0fq1q3k6u9mpy5rdxvk6wu5iy5tb4xpv';
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $data_res = [
            "q25_email" => $data["email"],
            "q3_wurdeDer" => $data['reached'],
            "q31_Erreichbarkeitsanmerkungen" => $data['additional_notices'] ?? "",
            "q4_recruiter" => $data['recruiter'] ?? "",
            "q7_abgeschlosseneAusbildung" => $data['education'] ?? "",
            "q29_wannWurde" => $data['education_complete'] ?? "",
            "q30_wechselmotivation" => $data['change_motivation'] ?? "",
            "q24_aktuellerBerufsstatus" => $data['professional_status'] ?? "",
            "q9_nachstmoglichesWechseldatum" => [
                "month" => explode("-", $data['next_possible_change'] ?? "")[1],
                "day" => explode("-", $data['next_possible_change'] ?? "")[2],
                "year" => explode("-", $data['next_possible_change'] ?? "")[0],
            ],
            "q19_gehaltsrange" => $data['salary_change'] ?? "",
            "q20_reisebereitschaft" => "",
            "q21_sprachniveau" => $data['german_level'] ?? "",
            "q36_timeslots" => [
                "shorttext-1" => $data['reachability'][0]["day"] ?? "",
                "time-2" => [
                    "timeInput" => $data['reachability'][0]["start"] ?? "",
                    "hourSelect" => explode(":", $data['reachability'][0]["start"] ?? "")[0],
                    "minuteSelect" => explode(":", $data['reachability'][1]["start"] ?? "")[0],
                ],
                "time-3" => [
                    "timeInput" => $data['reachability'][0]["end"] ?? "",
                    "hourSelect" => explode(":", $data['reachability'][0]["end"] ?? "")[0],
                    "minuteSelect" => explode(":", $data['reachability'][0]["end"] ?? "")[1],
                ],
                "shorttext-4" => $data['reachability'][1]["day"] ?? "",
                "time-5" => [
                    "timeInput" => $data['reachability'][1]["start"] ?? "",
                    "hourSelect" => explode(":", $data['reachability'][1]["start"] ?? "")[0],
                    "minuteSelect" => explode(":", $data['reachability'][1]["start"] ?? "")[1],
                ],
                "time-6" => [
                    "timeInput" => $data['reachability'][1]["end"] ?? "",
                    "hourSelect" => explode(":", $data['reachability'][1]["end"] ?? "")[0],
                    "minuteSelect" => explode(":", $data['reachability'][1]["end"] ?? "")[1],
                ],
                "shorttext-7" => $data['reachability'][2]["day"] ?? "",
                "time-8" => [
                    "timeInput" => $data['reachability'][2]["start"] ?? "",
                    "hourSelect" => explode(":", $data['reachability'][2]["start"] ?? "")[0],
                    "minuteSelect" => explode(":", $data['reachability'][2]["start"] ?? "")[1],
                ],
                "time-9" => [
                    "timeInput" => $data['reachability'][2]["end"] ?? "",
                    "hourSelect" => explode(":", $data['reachability'][2]["end"] ?? "")[0],
                    "minuteSelect" => explode(":", $data['reachability'][2]["end"] ?? "")[1],
                ]
            ],
            "q50_customer_question" => "",
            "q23_notizen" => $data['notes'] ?? "",
            "q49_requestCV" => "Nein",
            "successfullCC" => $data['successfullCC'] ?? ""
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data_res),
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === false) {
            return new DataResponse(
                ["data" => "couldn't process request"],
                Http::STATUS_INTERNAL_SERVER_ERROR,
            );
        }
        return new DataResponse(
            ["data" => "ok"],
            Http::STATUS_OK,
        );
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'GET', url: 'api/createApplicant')]
    public function createApplicant(): DataResponse
    {
        $url = 'https://hook.eu1.make.com/6tj1h88mmdo949uybal7rt2bb6ugq8xu';
        $data = [
            "personal_data" => [
                "firstname" => $_GET['firstname'] ?? '',
                "plz" => "",
                "lastname" => $_GET['lastname'] ?? '',
                "email" => $_GET['email'] ?? '',
                "LeadID" => "",
                "phone" => $_GET['phone'] ?? '',
                "cv" => "pending",
                "questions" => "W10="
            ],
            "general" => [
                "funnel" => $_GET['funnel'] ?? '',
                "origin" => "KI Recruiting",
                "source" => "onepage",
                "utm" => "eyJ1dG1fY2FtcGFpZ24iOiIiLCJ1dG1fY29udGVudCI6IiIsInV0bV9tZWRpdW0iOiIiLCJ1dG1fc291cmNlIjoiIiwidXRtX3Rlcm0iOiIifQ==",
                "status" => "create"
            ]
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === false) {
            return new DataResponse(
                ["data" => "couldn't process request"],
                Http::STATUS_INTERNAL_SERVER_ERROR,
            );
        }
        return new DataResponse(
            ["data" => "ok"],
            Http::STATUS_OK,
        );
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'POST', url: 'api/uploadCV')]
    public function uploadCV(): DataResponse
    {
        // Prüfen, ob eine Datei hochgeladen wurde
        if (!isset($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
            return new DataResponse(
                ["data" => "No file uploaded or an error occurred."],
                Http::STATUS_BAD_REQUEST
            );
        }

        // Datei-Daten und Ziel-URL vorbereiten
        $file = $_FILES['cv'];
        $email = $_POST['email'] ?? null;

        if (!$email) {
            return new DataResponse(
                ["data" => "Email is required."],
                Http::STATUS_BAD_REQUEST
            );
        }

        $url = 'https://hook.eu1.make.com/2w49uy6uxrspcz5dh1mffjfek5yin1qd';

        // cURL-Initialisierung
        $ch = curl_init();

        // Daten für die multipart/form-data-Anfrage erstellen
        $postData = [
            'email' => $email,
            'cv' => new \CURLFile($file['tmp_name'], $file['type'], $file['name'])
        ];

        // cURL-Optionen setzen
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        // Anfrage ausführen
        $result = curl_exec($ch);

        // Fehlerbehandlung
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return new DataResponse(
                ["data" => "File upload failed: $error"],
                Http::STATUS_INTERNAL_SERVER_ERROR
            );
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Überprüfung des HTTP-Statuscodes
        if ($httpCode !== 200) {
            return new DataResponse(
                ["data" => "File upload failed with status code $httpCode."],
                Http::STATUS_INTERNAL_SERVER_ERROR
            );
        }

        return new DataResponse(
            ["data" => "File uploaded successfully."],
            Http::STATUS_OK
        );
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'GET', url: 'api/queryJobs')]
    public function queryJobs(): DataResponse
    {
        $searchTerm = $_GET['searchTerm'] ?? '';
        $id = $_GET['compID'] ?? '';
        $filters = array(
            "searchTerm" => $searchTerm,
        );
        if ($id == '') {
            $jobs = $this->dbService->getJobsList(["funnel_name", "id"], $filters);
            return new DataResponse(
                ["data" => json_encode($jobs)],
                Http::STATUS_OK,
            );
        } else {
            $jobs = $this->dbService->getCompanyJobs(["title", "status", "id"], intval($id), $filters);
            return new DataResponse(
                ["data" => json_encode($jobs)],
                Http::STATUS_OK,
            );
        }
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'POST', url: 'api/setSatisfaction')]
    public function setSatisfaction(): DataResponse
    {
        // Parameter aus dem POST-Body abrufen
        $satisfaction = $_POST['satisfaction'] ?? '';
        $id = $_POST['compID'] ?? '';

        if ($id === '') {
            return new DataResponse(
                Http::STATUS_BAD_REQUEST
            );
        }

        if ($this->dbService->changeCompanySatisfaction(intval($id), intval($satisfaction))) {
            return new DataResponse(Http::STATUS_OK);
        }

        return new DataResponse(Http::STATUS_INTERNAL_SERVER_ERROR);
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'POST', url: 'api/logKBCall')]
    public function logKBCall(): DataResponse
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $job = intval($data["job"]);
        $selection = array(
            "upsell" => [$data["upsell"]["pitched"], $data["upsell"]["sold"]],
            "testimonial" => [$data["testimonial"]["pitched"], $data["testimonial"]["sold"]],
            "recommendation" => [$data["recommendation"]["pitched"], $data["recommendation"]["sold"]],
            "crossSell" => [$data["crossSell"]["pitched"], $data["crossSell"]["sold"]],
        );
        if ($this->dbService->logNewKBCall($job, $selection)) {
            return new DataResponse(Http::STATUS_OK);
        }
        return new DataResponse(Http::STATUS_INTERNAL_SERVER_ERROR);
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'POST', url: 'api/changeManagerNotification')]
    public function changeManagerNotification(): DataResponse
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $job = intval($data["job"]);
        $manager = $data["manager"];
        $mode = $data["mode"];
        if ($this->dbService->changeJobNotification($job, $manager, $mode)) {
            return new DataResponse([], Http::STATUS_OK);
        }
        return new DataResponse(Http::STATUS_INTERNAL_SERVER_ERROR);
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'POST', url: 'api/updateJobNotes')]
    public function changeJobNotes(): DataResponse
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $job = intval($data["job"]);
        $note = $data["note"];
        if ($this->dbService->updateJobNote($job, $note)) {
            return new DataResponse([], Http::STATUS_OK);
        }
        return new DataResponse(Http::STATUS_INTERNAL_SERVER_ERROR);
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'POST', url: 'api/updateJobCustomerVisit')]
    public function updateJobCustomerVisit(): DataResponse
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $job = intval($data["job"]);
        $date = strval($data["date"]);
        if ($this->dbService->updateJobCustomerVisit($job, $date)) {
            return new DataResponse([], Http::STATUS_OK);
        }
        return new DataResponse(Http::STATUS_INTERNAL_SERVER_ERROR);
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'POST', url: 'api/setManualStartDate')]
    public function manuallySetStartDate(): DataResponse
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $job = intval($data["job"]);
        $date = strval($data["date"]);
        if ($this->dbService->setJobStartDate($job, $date)) {
            return new DataResponse([], Http::STATUS_OK);
        }
        return new DataResponse(Http::STATUS_INTERNAL_SERVER_ERROR);
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'POST', url: 'api/updateJobPosting')]
    public function updateJobPostingData(): DataResponse
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $job = intval($data["job"]);
        $jobResult = $this->dbService->getJob(["jobFolder", "company"], $job);
        $jobFolderPath = $jobResult["jobFolder"];
        $company = intval($jobResult["company"]);
        $companyLogoLink = $this->fileService->getCompanyLogoLink("03 Marketing/01 Kunden Marketing/" . $jobFolderPath);
        // update company Logo
        if ($companyLogoLink != "" && $company != null && $this->dbService->updateCompanyLogo($company, $companyLogoLink . "/download")) {
            return new DataResponse([], Http::STATUS_OK);
        }
        try {
            $links = $this->fileService->getAllPostingLinks($jobFolderPath);
        } catch (\Throwable $th) {
            $links = [];
        }
        $updateJobData = array();
        $action = htmlspecialchars(strip_tags($data["action"]), ENT_QUOTES, 'UTF-8');
        $updateJobData["title"] = htmlspecialchars(strip_tags($data["title"]), ENT_QUOTES, 'UTF-8');
        $updateJobData["descProf"] = htmlspecialchars($data["descProf"]);
        $updateJobData["descSoc"] = htmlspecialchars($data["descSoc"]);
        $updateJobData["link"] = htmlspecialchars(strip_tags($data["link"]), ENT_QUOTES, 'UTF-8');
        $updateJobData["plz"] = htmlspecialchars(strip_tags($data["plz"]), ENT_QUOTES, 'UTF-8');
        $updateJobData["salaryMin"] = htmlspecialchars(strip_tags($data["salaryMin"]), ENT_QUOTES, 'UTF-8');
        $updateJobData["salaryMax"] = htmlspecialchars(strip_tags($data["salaryMax"]), ENT_QUOTES, 'UTF-8');
        $updateJobData["ebay1"] = htmlspecialchars(strip_tags($data["ebay1"]), ENT_QUOTES, 'UTF-8');
        $updateJobData["ebay2"] = htmlspecialchars(strip_tags($data["ebay2"]), ENT_QUOTES, 'UTF-8');
        $updateJobData["asp"] = htmlspecialchars(strip_tags($data["asp"]), ENT_QUOTES, 'UTF-8');
        $updateJobData["benefits"] = $data["benefits"];
        // get media changes
        $updateJobData["media"] = $links;
        if ($this->dbService->updateJobData($job, $updateJobData)) {
            if ($action == "Freigabe anfordern") {
                $this->dbService->updateJobStatus($job, "In revision");
            } elseif ($action == "Zur Kundenrevision freigeben") {
                // handle sharing revision in Make
                $data = ['data' => $updateJobData, 'job' => $job, 'action' => 'shareForRevision'];
                $options = [
                    'http' => [
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => 'POST',
                        'content' => http_build_query($data),
                    ],
                ];
                $context = stream_context_create($options);
                $result = file_get_contents($this->makeEndpoint, false, $context);
            }
            return new DataResponse(Http::STATUS_INTERNAL_SERVER_ERROR);
        }
        return new DataResponse(Http::STATUS_INTERNAL_SERVER_ERROR);
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'POST', url: 'api/jobActivityActions')]
    public function updatejobActivityActions(): DataResponse
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $job = intval($data["job"]);
        $action = htmlspecialchars(strip_tags($data["action"]), ENT_QUOTES, 'UTF-8');
        $context = htmlspecialchars(strip_tags($data["context"]), ENT_QUOTES, 'UTF-8');
        if ($action != "visibility") {
            $data = ['button' => $action, 'job' => $job, 'action' => 'jobActivityButtons'];
            $options = [
                'http' => [
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data),
                ],
            ];
            $context = stream_context_create($options);
            $result = file_get_contents($this->makeEndpoint, false, $context);
            if (!$result === false) {
                return new DataResponse(Http::STATUS_OK);
            }
        }
        if ($action == "visibility") {
            // toggle job visibility
            if ($context == "setOnline") {
                $this->dbService->updateJobStatus($job, "active");
            } elseif ($context == "setOffline") {
                $this->dbService->updateJobStatus($job, "archieved");
            }
            return new DataResponse(Http::STATUS_OK);
        }
        return new DataResponse(Http::STATUS_INTERNAL_SERVER_ERROR);
    }
}
