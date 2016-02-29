<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\BackendModule;

use GoClimb\Modules\BasePresenter;
use Nette\Application\Request;


abstract class BaseBackendPresenter extends BasePresenter
{


	public function beforeRender()
	{
		$loginBacklink = $this->link('//this', ['do' => 'tokenLogin', 'token' => $this::TOKEN_PLACEHOLDER]);
		$logoutBacklink = $this->link('//this', ['do' => 'logout']);

		$this->template->loginLink = $this->getLoginLink($this->getApplicationToken(), $loginBacklink);
		$this->template->logoutLink = $this->getLogoutLink($this->getApplicationToken(), $logoutBacklink);
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
}
