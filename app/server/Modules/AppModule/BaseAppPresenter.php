<?php

namespace GoClimb\Modules\AppModule;

use GoClimb\Model\Entities\Application;
use GoClimb\Modules\BasePresenter;
use Nette\Application\Request;


abstract class BaseAppPresenter extends BasePresenter
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
	}


	protected function init(Request $request)
	{
		$this->applicationPartsManager->setAsApp();
	}

	/**
	 * @inheritdoc
	 */
	protected function getApplicationToken()
	{
		return Application::APP_TOKEN;
	}

}
