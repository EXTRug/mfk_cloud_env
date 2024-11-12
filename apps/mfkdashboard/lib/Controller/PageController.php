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

/**
 * @psalm-suppress UnusedClass
 */
class PageController extends Controller
{
	private $dbService;
	private $userSession;
    private $groupManager;
	public function __construct(IUserSession $userSession, IGroupManager $groupManager) {
        $this->dbService = new DatabaseService();
		$this->userSession = $userSession;
        $this->groupManager = $groupManager;
    }

	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/company-overview')]
	public function companiesOverview($mode="hr"): TemplateResponse
	{
		if(!$this->simpleAccessControl("companyOverview")){
			return new TemplateResponse(
				Application::APP_ID,
				'misc/notAllowed'
			);
		}
		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'tom-select');
		\OCP\Util::addScript('mfkdashboard', 'pages/companiesOverview');

		$data = [
			'navLinks' => $this->getAllowedNavbarLinks(),
            'companies' => $this->dbService->getCompanies(["companyID","name"]),
			'mode' => $mode,
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
	#[FrontpageRoute(verb: 'GET', url: '/company-overview/hr')]
	public function companiesOverviewHR(): TemplateResponse
	{
		return $this->companiesOverview("hr");
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/company-overview/kb')]
	public function companiesOverviewKB(): TemplateResponse
	{
		return $this->companiesOverview("kb");
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/company-jobs/{mode}/{id}')]
	public function companyJobs(string $mode="hr",int $id): TemplateResponse
	{
		if(!$this->simpleAccessControl("companyJobs")){
			return new TemplateResponse(
				Application::APP_ID,
				'misc/notAllowed'
			);
		}
		// Add the JavaScript file from the js/ folder
		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addStyle('mfkdashboard', 'tom-select');

		\OCP\Util::addScript('mfkdashboard', 'tom-select');
		\OCP\Util::addScript('mfkdashboard', 'pages/jobsOverview');
		if($mode == "hr"){
			$link = "edit-job";
		}else{
			$link = "job-activity";
		}

		$data = [
			'navLinks' => $this->getAllowedNavbarLinks(),
            'company' => $this->dbService->getCompany(["name"],$id),
			'jobs' => $this->dbService->getCompanyJobs(["title","status","id", "status"], $id),
			'followingLink' => $link,
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
		if(!$this->simpleAccessControl("editJob")){
			return new TemplateResponse(
				Application::APP_ID,
				'misc/notAllowed'
			);
		}
		\OCP\Util::addStyle('mfkdashboard', 'quill');
		\OCP\Util::addStyle('mfkdashboard', 'tom-select');

		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'quill');
		\OCP\Util::addScript('mfkdashboard', 'tom-select');
		\OCP\Util::addScript('mfkdashboard', 'main');


		$data = [
			'navLinks' => $this->getAllowedNavbarLinks(),
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
	#[FrontpageRoute(verb: 'GET', url: '/job-activity/{id}')]
	public function jobActivity(int $id): TemplateResponse
	{
		if(!$this->simpleAccessControl("jobActivity")){
			return new TemplateResponse(
				Application::APP_ID,
				'misc/notAllowed'
			);
		}
		\OCP\Util::addStyle('mfkdashboard', 'quill');
		\OCP\Util::addStyle('mfkdashboard', 'tom-select');

		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'quill');
		\OCP\Util::addScript('mfkdashboard', 'tom-select');
		\OCP\Util::addScript('mfkdashboard', 'main');

		$data = [
			'navLinks' => $this->getAllowedNavbarLinks(),
            'job' => $this->dbService->getJob(["title","id", "funnel_name", "company","location", "status"],$id),
        ];
		// Return the template response
		return new TemplateResponse(
			Application::APP_ID,
			'kb/jobActivity',
			$data
		);
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/add-applicant')]
	public function applicant(): TemplateResponse
	{
		if(!$this->simpleAccessControl("addApplicant")){
			return new TemplateResponse(
				Application::APP_ID,
				'misc/notAllowed'
			);
		}
		\OCP\Util::addStyle('mfkdashboard', 'quill');
		\OCP\Util::addStyle('mfkdashboard', 'tom-select');

		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'quill');
		\OCP\Util::addScript('mfkdashboard', 'tom-select');
		\OCP\Util::addScript('mfkdashboard', 'main');


		// Return the template response
		return new TemplateResponse(
			Application::APP_ID,
			'misc/addApplicant'
		);
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/candidate-call/{id}/{email}')]
	public function candidateCall(int $id, string $email): TemplateResponse
	{
		if(!$this->simpleAccessControl("candidateCall")){
			return new TemplateResponse(
				Application::APP_ID,
				'misc/notAllowed'
			);
		}
		\OCP\Util::addStyle('mfkdashboard', 'quill');
		\OCP\Util::addStyle('mfkdashboard', 'tom-select');

		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'quill');
		\OCP\Util::addScript('mfkdashboard', 'tom-select');
		\OCP\Util::addScript('mfkdashboard', 'main');

		$job = $this->dbService->getJob(["title","location", "company", "funnel_name", "campaign"],$id);
		$data = [
			'navLinks' => $this->getAllowedNavbarLinks(),
            'job' => $job,
			'company' => $this->dbService->getCompany(["name","website"],$job["company"]),
			'applicant' => $this->dbService->getApplicant(["firstname","lastname", "cv", "joined", "interviewQS"],$email, $job["funnel_name"]),
        ];
		// Return the template response
		return new TemplateResponse(
			Application::APP_ID,
			'caller/candidateCall',
			$data
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
    private function simpleAccessControl($page) {
        $user = $this->userSession->getUser();
        $groups = $this->groupManager->getUserGroups($user);
		switch ($page) {
			case 'candidateCall':
				return strpos(json_encode($groups),'Caller');
				break;
			case 'addApplicant':
				return strpos(json_encode($groups),'MFK intern');
				break;
			case 'jobActivity':
				return strpos(json_encode($groups),'MFK intern');
				break;
			case 'editJob':
				return strpos(json_encode($groups),'MFK intern');
				break;
			case 'companyJobs':
				return strpos(json_encode($groups),'MFK intern');
				break;
			case 'companyOverview':
				return strpos(json_encode($groups),'MFK intern');
				break;
			default:
				return false;
				break;
		}
		return false;
    }

	private function getAllowedNavbarLinks(){
		$user = $this->userSession->getUser();
        $groups = $this->groupManager->getUserGroups($user);
		$links = array();
		if(strpos(json_encode($groups),'Caller')){
			array_push($links, array("title" => "CC Call", "path" => "candidate-call"));
		}
		if(strpos(json_encode($groups),'MFK intern')){
			array_push($links, array("title" => "KB Dashboard", "path" => "company-overview/kb"));
		}
		if(strpos(json_encode($groups),'MFK intern')){
			array_push($links, array("title" => "HR Dashboard", "path" => "company-overview/hr"));
		}
		return $links;
	}
}
