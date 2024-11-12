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
    public function queryCompanies(): DataResponse {
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
    #[ApiRoute(verb: 'GET', url: 'api/queryJobs')]
    public function queryJobs(): DataResponse {
        $searchTerm = $_GET['searchTerm'] ?? '';
        $id = $_GET['compID'] ?? '';
        if($id == ''){
            return new DataResponse(
                Http::STATUS_BAD_REQUEST,
            );
        }
    
        $filters = array(
            "searchTerm" => $searchTerm,
        );
    
        $companies = $this->dbService->getCompanyJobs(["title", "status", "id"],$id, $filters);
    
        return new DataResponse(
            ["data" => json_encode($companies)],
            Http::STATUS_OK,
        );
    }
}
