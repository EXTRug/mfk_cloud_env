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
	#[FrontpageRoute(verb: 'GET', url: '/hr')]
	public function hr(): TemplateResponse
	{
		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		$data = [
            'title' => 'Hello from Nextcloud',
			"groups" => $this->getUserGroups(),
        ];
		return new TemplateResponse(
			Application::APP_ID,
			'/hr/index',
			$data,
		);
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/show')]
	public function demo(): TemplateResponse
	{
		// Add the JavaScript file from the js/ folder
		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');

		// Return the template response
		return new TemplateResponse(
			Application::APP_ID,
			'hr/show'
		);
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/details')]
	public function details(): TemplateResponse
	{

		\OCP\Util::addStyle('mfkdashboard', 'quill');

		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'quill');
		\OCP\Util::addScript('mfkdashboard', 'main');

		// Return the template response
		return new TemplateResponse(
			Application::APP_ID,
			'hr/details'
		);
	}
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[OpenAPI(OpenAPI::SCOPE_IGNORE)]
	#[FrontpageRoute(verb: 'GET', url: '/add-applicant')]
	public function applicant(): TemplateResponse
	{

		\OCP\Util::addStyle('mfkdashboard', 'quill');

		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'quill');
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

		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'quill');
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

		\OCP\Util::addScript('mfkdashboard', 'bootstrap.bundle.min');
		\OCP\Util::addScript('mfkdashboard', 'quill');
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
