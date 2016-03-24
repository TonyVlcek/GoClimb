<?php

namespace GoClimb\Modules\BackendModule;

use GoClimb\Model\Entities\Application;
use GoClimb\Model\Enums\AclPrivilege;
use GoClimb\Model\Enums\AclResource;
use GoClimb\Modules\BasePresenter;
use Nette\Application\Request;


abstract class BaseBackendPresenter extends BasePresenter
{

	public function beforeRender()
	{
		$loginBacklink = $this->link('//this', ['do' => 'tokenLogin', 'token' => $this::TOKEN_PLACEHOLDER]);
		$logoutBacklink = $this->link('//this', ['do' => 'logout']);

		$loginLink = $this->getLoginLink($this->getApplicationToken(), $loginBacklink);
		$logoutLink = $this->getLogoutLink($this->getApplicationToken(), $logoutBacklink);

		if (!$this->isAllowedToBackend()) {
			$this->redirectUrl($loginLink);
		}

		$this->template->loginLink = $loginLink;
		$this->template->logoutLink = $logoutLink;
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
			if ($this->user->isAllowed($resource, AclPrivilege::READ)) {
				return TRUE;
			}
		}
		return FALSE;
	}

}
