<?php

namespace GoClimb\Modules\BackendModule;

use GoClimb\Model\Entities\Application;
use GoClimb\Model\Enums\AclResource;
use GoClimb\Modules\BasePresenter;
use Nette\Application\Request;


abstract class BaseBackendPresenter extends BasePresenter
{

	public function startup()
	{
		parent::startup();

		$loginBacklink = $this->link('//this', [$this::LOGIN_PARAMETER => $this::TOKEN_PLACEHOLDER]);
		$logoutBacklink = $this->link('//this', [$this::LOGOUT_PARAMETER => 1]);

		$loginLink = $this->getLoginLink($this->getApplicationToken(), $loginBacklink);
		$logoutLink = $this->getLogoutLink($this->getApplicationToken(), $logoutBacklink);

		$this->template->loginLink = $loginLink;
		$this->template->logoutLink = $logoutLink;

		if (!$this->user->isLoggedIn()) {
			$this->redirectUrl($loginLink);
		}

		if (!$this->isAllowedToBackend()) {
			$this->template->setFile(__DIR__ . "/templates/Error/forbidden.latte");
			$this->sendTemplate();
		}
	}


	protected function init(Request $request)
	{
		$this->applicationPartsManager->setAsBackend();
	}


	/**
	 * @inheritdoc
	 */
	protected function getApplicationToken()
	{
		return Application::BACKEND_TOKEN;
	}


	/**
	 * @return bool
	 */
	private function isAllowedToBackend()
	{
		foreach (AclResource::getBackend() as $resource) {
			if ($this->user->isAllowed($resource)) {
				return TRUE;
			}
		}
		return FALSE;
	}

}
