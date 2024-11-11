<?php

declare(strict_types=1);

namespace OCA\MFKDashboard\Controller;
use OCA\MFKDashboard\Service\DatabaseService;

use OCA\MFKDashboard\AppInfo\Application;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Attribute\FrontpageRoute;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\Http\Attribute\OpenAPI;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IUserSession;
use OCP\IGroupManager;
use OCP\IURLGenerator;

/**
 * @psalm-suppress UnusedClass
 */
class PageController extends Controller
{
	private $dbService;
	private $userSession;
    private $groupManager;
	private $urlGenerator;
	public function __construct(IUserSession $userSession, IGroupManager $groupManager,IURLGenerator $urlGenerator) {
        $this->dbService = new DatabaseService();
		$this->userSession = $userSession;
        $this->groupManager = $groupManager;
		$this->urlGenerator = $urlGenerator;
    }

	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/company-overview')]
	public function companiesOverview(): TemplateResponse
	{
		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'tom-select');

		$data = [
            'companies' => $this->dbService->getCompanies(["companyID","name"]),
        ];
		return new TemplateResponse(
			Application::APP_ID,
			'/hr/companiesList',
			$data,
		);
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/company-jobs/{id}')]
	public function companyJobs(int $id): TemplateResponse
	{
		// Add the JavaScript file from the js/ folder
		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addStyle('mfkdashboard', 'tom-select');

		\OCP\Util::addScript('mfkdashboard', 'tom-select');

		$data = [
            'company' => $this->dbService->getCompany(["name"],$id),
			'jobs' => $this->dbService->getCompanyJobs(["title","status","id", "status"], $id),
			'followingLink' => "edit-job"
        ];
		// Return the template response
		return new TemplateResponse(
			Application::APP_ID,
			'hr/companyJobs',
			$data
		);
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/edit-job/{id}')]
	public function jobSetup(int $id): TemplateResponse
	{

		\OCP\Util::addStyle('mfkdashboard', 'quill');
		\OCP\Util::addStyle('mfkdashboard', 'tom-select');

		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'quill');
		\OCP\Util::addScript('mfkdashboard', 'tom-select');
		\OCP\Util::addScript('mfkdashboard', 'main');


		$data = [
            'job' => $this->dbService->getJob(["title","id", "funnel_name", "company","location", "status"],$id),
        ]; 
		// Return the template response
		return new TemplateResponse(
			Application::APP_ID,
			'hr/jobEdit',
			$data
		);
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/add-applicant')]
	public function applicant(): TemplateResponse
	{

		\OCP\Util::addStyle('mfkdashboard', 'quill');
		\OCP\Util::addStyle('mfkdashboard', 'tom-select');

		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'quill');
		\OCP\Util::addScript('mfkdashboard', 'tom-select');
		\OCP\Util::addScript('mfkdashboard', 'main');


		// Return the template response
		return new TemplateResponse(
			Application::APP_ID,
			'hr/applicant'
		);
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/service-details')]
	public function service(): TemplateResponse
	{

		\OCP\Util::addStyle('mfkdashboard', 'quill');
		\OCP\Util::addStyle('mfkdashboard', 'tom-select');

		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'quill');
		\OCP\Util::addScript('mfkdashboard', 'tom-select');
		\OCP\Util::addScript('mfkdashboard', 'main');


		// Return the template response
		return new TemplateResponse(
			Application::APP_ID,
			'hr/service'
		);
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/muster-job')]
	public function muster(): TemplateResponse
	{

		\OCP\Util::addStyle('mfkdashboard', 'quill');
		\OCP\Util::addStyle('mfkdashboard', 'tom-select');

		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'quill');
		\OCP\Util::addScript('mfkdashboard', 'tom-select');
		\OCP\Util::addScript('mfkdashboard', 'main');

		// Return the template response
		return new TemplateResponse(
			Application::APP_ID,
			'hr/muster-job'
		);
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/')]
	public function index(): TemplateResponse
	{
		return new TemplateResponse(
			Application::APP_ID,
			'index',
		);
	}

	 /**
     * @NoAdminRequired
     */
    private function getUserGroups() {
        $user = $this->userSession->getUser();
        if ($user) {
            $groups = $this->groupManager->getUserGroups($user);
            $groupNames = array_map(function($group) {
                return $group->getGID();
            }, $groups);

            return $groupNames;
        }
        
        return[];
    }
}
