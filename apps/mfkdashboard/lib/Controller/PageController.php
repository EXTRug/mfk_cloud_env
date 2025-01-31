<?php

declare(strict_types=1);

namespace OCA\MFKDashboard\Controller;

use OCA\MFKDashboard\Service\DatabaseService;
use OCA\MFKDashboard\Service\FilesService;
use OCA\MFKDashboard\Utils\DesignHelper;

use OCA\Circles\CirclesManager;
use OCA\Circles\Model\FederatedUser;
use OCA\Circles\Model\Member;


use OCA\MFKDashboard\AppInfo\Application;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Attribute\FrontpageRoute;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\Http\Attribute\OpenAPI;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IUserSession;
use OCP\IGroupManager;
use OCP\Server;

/**
 * @psalm-suppress UnusedClass
 */
class PageController extends Controller
{
	private $ISDEV = True;
	private $dbService;
	private $userSession;
	private $groupManager;
	private FilesService $fileService;
	public function __construct(IUserSession $userSession, IGroupManager $groupManager, FilesService $fileService)
	{
		$this->dbService = new DatabaseService();
		$this->userSession = $userSession;
		$this->fileService = $fileService;
		$this->groupManager = $groupManager;
	}

	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/company-overview')]
	public function companiesOverview($mode = "hr"): TemplateResponse
	{
		if (!$this->simpleAccessControl("companyOverview")) {
			return $this->applicant();
		}
		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'tom-select');
		\OCP\Util::addScript('mfkdashboard', 'pages/companiesOverview');

		$data = [
			'navLinks' => $this->getAllowedNavbarLinks(),
			'companies' => $this->dbService->getCompanies(["companyID", "name", "satisfaction"], ["onlyActive" => true]),
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
	#[FrontpageRoute(verb: 'GET', url: '/company-jobs/hr/createjob/{id}')]
	public function createNewJob(int $id): TemplateResponse
	{
		if (!$this->simpleAccessControl("companyOverview")) {
			return new TemplateResponse(
				Application::APP_ID,
				'misc/notAllowed'
			);
		}
		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');

		$data = [
			'navLinks' => $this->getAllowedNavbarLinks(),
			'company' => $this->dbService->getCompany(["name", "billing_id"], $id)
		];
		return new TemplateResponse(
			Application::APP_ID,
			'/hr/createJob',
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
	public function companyJobs(string $mode = "hr", int $id): TemplateResponse
	{
		if (!$this->simpleAccessControl("companyJobs")) {
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
		if ($mode == "hr") {
			$link = "edit-job";
		} else {
			$link = "job-activity";
		}

		$data = [
			'navLinks' => $this->getAllowedNavbarLinks(),
			'company' => $this->dbService->getCompany(["name"], $id),
			'id' => $id,
			'jobs' => $this->dbService->getCompanyJobs(["title", "status", "id", "status", "assignedColor"], $id, [], true),
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
		if (!$this->simpleAccessControl("editJob")) {
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
		\OCP\Util::addScript('mfkdashboard', 'pages/jobEdit');

		$job = $this->dbService->getJob(["title", "id", "funnel_name", "company", "location", "status", "campaign", "funnel_url", "salary_range", "customerInput", "asp", "jobFolder"], $id);
		try {
			$numberOfFiles = intval($this->fileService->getNumberOfFiles("03 Marketing/01 Kunden Marketing/" . $job["jobFolder"] . "/Werbematerial/Ausgewählte Bildmaterialien"));
		} catch (\Throwable $th) {
			$numberOfFiles = -1;
		}

		$data = [
			'navLinks' => $this->getAllowedNavbarLinks(),
			'job' => $job,
			'company' => $this->dbService->getCompany(["name", "description"], intval($job["company"])),
			'statusColor' => DesignHelper::getStatusColor($job["status"]),
			'numberOfFiles' => $numberOfFiles
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
		if (!$this->simpleAccessControl("jobActivity")) {
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
		\OCP\Util::addScript('mfkdashboard', 'pages/jobActivity');

		$job = $this->dbService->getJob(["title", "id", "funnel_name", "company", "location", "status", "history", "startDate","stopDate", "manager", "internalNote", "scheduledCustomerVisit"], $id);
		$data = [
			'navLinks' => $this->getAllowedNavbarLinks(),
			'job' => $job,
			'company' => $this->dbService->getCompany(["satisfaction", "manager"], intval($job["company"])),
			'topApplicants' => $this->dbService->getTopBewerber(['firstname', 'lastname', 'progress.score', 'cv', 'joined', 'email'], $job["funnel_name"]),
			'calls' => $this->dbService->getCallHistory($id),
			'statusColor' => DesignHelper::getStatusColor($job["status"])
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
		if (!$this->simpleAccessControl("addApplicant")) {
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
		\OCP\Util::addScript('mfkdashboard', 'pages/addApplicant');

		$data = [
			'navLinks' => $this->getAllowedNavbarLinks(),
			'jobs' => $this->dbService->getJobsList(["id", "funnel_name"])
		];

		// Return the template response
		return new TemplateResponse(
			Application::APP_ID,
			'misc/addApplicant',
			$data
		);
	}

	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/candidate-call/{id}/{email}')]
	public function candidateCallView(int $id, string $email): TemplateResponse
	{
		if (!$this->simpleAccessControl("candidateCall")) {
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
		\OCP\Util::addScript('mfkdashboard', 'pages/candidateCall');

		$job = $this->dbService->getJob(["title", "location", "company", "funnel_name", "campaign"], $id);
		$data = [
			'navLinks' => $this->getAllowedNavbarLinks(),
			'job' => $job,
			'company' => $this->dbService->getCompany(["name", "website"], $job["company"]),
			'applicant' => $this->dbService->getApplicant(["firstname", "lastname", "cv", "joined", "interviewQS"], $email, $job["funnel_name"]),
			'recruiter' => "Karl Deutschmann"
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
	#[FrontpageRoute(verb: 'GET', url: '/candidate-call')]
	public function candidateOverview(): TemplateResponse
	{
		if (!$this->simpleAccessControl("candidateCall")) {
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
		\OCP\Util::addScript('mfkdashboard', 'pages/candidateCall');


		$data = [
			'navLinks' => $this->getAllowedNavbarLinks(),
		];

		return new TemplateResponse(
			Application::APP_ID,
			'caller/candidatesOverview',
			$data
		);
	}

	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/')]
	public function index(): TemplateResponse
	{
		$pages = $this->getAllowedNavbarLinks();
		$navigateTo = $pages[0]["path"];
		return new TemplateResponse(
			Application::APP_ID,
			'index',
			["navigateTo" => $navigateTo]
		);
	}

	/**
	 * @NoAdminRequired
	 */
	private function simpleAccessControl($page)
	{
		if ($this->ISDEV) {
			return True;
		}
		$user = $this->userSession->getUser();
		$circlesManager = Server::get(CirclesManager::class);
		$federatedUser = $circlesManager->getFederatedUser($user->getUID(), Member::TYPE_USER);
		$circles = $federatedUser->getMemberships();

		$groups = $this->groupManager->getUserGroups($user);
		$teams = [];
		foreach ($circles as $circle) {
			array_push($teams, $circle->getCircleId());
		}
		if (in_array("wvAZurJehKOYrUpChJYDI7lYPBwDGBV", $teams)) {
			return true;
		}
		switch ($page) {
			case 'candidateCall':
				return in_array("L8dSXHMmEUq3Z2AoEozpvQkpajuOjOX", $teams);
				return strpos(json_encode($groups), 'Caller');
			case 'addApplicant':
				return in_array("8NGHTVsMWFeHybaQDWgJX1sfYKbqcRo", $teams) || in_array("L8dSXHMmEUq3Z2AoEozpvQkpajuOjOX", $teams);
			case 'jobActivity':
				return  in_array("wpOHsPeXhnsFW5iNX8aMh6j7nMen7sV", $teams);
			case 'editJob':
				return in_array("xRLh38Myv745MTO3ZCOW6owA3SOhKIt", $teams);
			case 'companyJobs':
				return in_array("xRLh38Myv745MTO3ZCOW6owA3SOhKIt", $teams) || in_array("wpOHsPeXhnsFW5iNX8aMh6j7nMen7sV", $teams);
			case 'companyOverview':
				return in_array("xRLh38Myv745MTO3ZCOW6owA3SOhKIt", $teams) || in_array("wpOHsPeXhnsFW5iNX8aMh6j7nMen7sV", $teams);
			default:
				return false;
				break;
		}
		return false;
	}

	private function getAllowedNavbarLinks()
	{
		$links = array();
		if ($this->ISDEV) {
			array_push($links, array("title" => "CC Call", "path" => "candidate-call"));
			array_push($links, array("title" => "KB Dashboard", "path" => "company-overview/kb"));
			array_push($links, array("title" => "HR Dashboard", "path" => "company-overview/hr"));
			array_push($links, array("title" => "neuer Bewerber", "path" => "add-applicant"));
			return $links;
		}
		$user = $this->userSession->getUser();
		$circlesManager = Server::get(CirclesManager::class);
		$federatedUser = $circlesManager->getFederatedUser($user->getUID(), Member::TYPE_USER);
		$circles = $federatedUser->getMemberships();
		$groups = $this->groupManager->getUserGroups($user);
		$teams = [];
		foreach ($circles as $circle) {
			array_push($teams, $circle->getCircleId());
		}

		if (in_array("L8dSXHMmEUq3Z2AoEozpvQkpajuOjOX", $teams) || in_array("wvAZurJehKOYrUpChJYDI7lYPBwDGBV", $teams)) {
			array_push($links, array("title" => "CC Call", "path" => "candidate-call"));
		}
		if (in_array("wpOHsPeXhnsFW5iNX8aMh6j7nMen7sV", $teams) || in_array("wvAZurJehKOYrUpChJYDI7lYPBwDGBV", $teams)) {
			array_push($links, array("title" => "KB Dashboard", "path" => "company-overview/kb"));
		}
		if (in_array("xRLh38Myv745MTO3ZCOW6owA3SOhKIt", $teams) || in_array("wvAZurJehKOYrUpChJYDI7lYPBwDGBV", $teams)) {
			array_push($links, array("title" => "HR Dashboard", "path" => "company-overview/hr"));
		}
		if (in_array("8NGHTVsMWFeHybaQDWgJX1sfYKbqcRo", $teams) || in_array("wvAZurJehKOYrUpChJYDI7lYPBwDGBV", $teams) || in_array("L8dSXHMmEUq3Z2AoEozpvQkpajuOjOX", $teams)) {
			array_push($links, array("title" => "neuer Bewerber", "path" => "add-applicant"));
		}
		return $links;
	}
}
