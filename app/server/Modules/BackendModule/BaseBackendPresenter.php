<?php

namespace GoClimb\Modules\BackendModule;

use GoClimb\Model\Enums\Privilege;
use GoClimb\Model\Enums\Resource;
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
		return 'admin';
	}


	/**
	 * @return bool
	 */
	private function isAllowedToBackend()
	{
		foreach (Resource::getBackend() as $resource) {
			if ($this->user->isAllowed($resource, Privilege::READ)) {
				return TRUE;
			}
		}
		return FALSE;
	}

}
