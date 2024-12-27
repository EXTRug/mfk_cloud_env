<?php

declare(strict_types=1);

namespace OCA\MFKDashboard\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Http\ContentSecurityPolicy;

class Application extends App implements IBootstrap {
	public const APP_ID = 'mfkdashboard';

	/** @psalm-suppress PossiblyUnusedMethod */
	public function __construct() {
		parent::__construct(self::APP_ID);
	}

	public function register(IRegistrationContext $context): void {
		$csp = new ContentSecurityPolicy();
        $csp->addAllowedFrameDomain('https://form.jotform.com');
        \OC::$server->getContentSecurityPolicyManager()->addDefaultPolicy($csp);
	}

	public function boot(IBootContext $context): void {
	}
}
