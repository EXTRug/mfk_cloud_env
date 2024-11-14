<?php

declare(strict_types=1);

namespace OCA\MFKDashboard\Controller;

use OCA\MFKDashboard\Service\DatabaseService;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\Attribute\ApiRoute;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\IUserSession;
use OCP\IGroupManager;
use OCP\AppFramework\OCSController;
use OCP\IRequest;

class ApiController extends OCSController
{

    private DatabaseService $dbService;

    public function __construct(DatabaseService $dbService, IRequest $request)
    {
        // Richtiges Aufrufen des Elternkonstruktors mit beiden Parametern
        parent::__construct('mfkdashboard', $request);
        $this->dbService = $dbService;
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    #[ApiRoute(verb: 'GET', url: 'api/queryCompanies')]
    public function queryCompanies(): DataResponse
    {
        $searchTerm = $_GET['searchTerm'] ?? '';

        $filters = array(
            "searchTerm" => $searchTerm,
        );

        $companies = $this->dbService->getCompanies(["companyID", "name"], $filters);

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

        $url = 'https://hook.eu1.make.com/gi5eaftusy05b2dd2b8xph9rf5k2m9ax';
        $data = ['test1' => $email, 'test2' => $id];

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
                ["data" => "coulnd't process request"],
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
    #[ApiRoute(verb: 'GET', url: 'api/queryJobs')]
    public function queryJobs(): DataResponse
    {
        $searchTerm = $_GET['searchTerm'] ?? '';
        $id = $_GET['compID'] ?? '';
        if ($id == '') {
            return new DataResponse(
                Http::STATUS_BAD_REQUEST,
            );
        }

        $filters = array(
            "searchTerm" => $searchTerm,
        );

        $companies = $this->dbService->getCompanyJobs(["title", "status", "id"], intval($id), $filters);

        return new DataResponse(
            ["data" => json_encode($companies)],
            Http::STATUS_OK,
        );
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
}
