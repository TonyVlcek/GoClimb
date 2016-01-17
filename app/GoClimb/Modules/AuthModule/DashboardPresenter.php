<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\AuthModule;

use GoClimb\Model\Entities\Application;
use GoClimb\UI\Forms\User\ISignInFormFactory;


final class DashboardPresenter extends BaseAuthPresenter
{

	/** @var ISignInFormFactory */
	private $signInFormFactory;

	/** @var Application */
	private $application;

	/** @var string */
	private $back;


	public function __construct(ISignInFormFactory $signInFormFactory)
	{
		parent::__construct();
		$this->signInFormFactory = $signInFormFactory;
	}


	public function actionLogin($token, $back)
	{
		$this->back = $back;
		if (!$this->application = $this->authFacade->getApplicationByToken($token)) {
			$this->redirectUrl($this->addTokenToUrl($back, NULL));
		}
		if ($this->user->isLoggedIn()) {
			$this->redirectLoggedUser();
		}
	}


	public function actionLogout($back)
	{
		$this->user->logout(TRUE);
		$this->redirectUrl($this->addTokenToUrl($back, NULL));
	}


	protected function createComponentSignInForm()
	{
		$form = $this->signInFormFactory->create();
		$form->onSuccess[] = [$this, 'redirectLoggedUser'];
		return $form;
	}


	public function redirectLoggedUser()
	{
		$token = $this->authFacade->getLoginTokenForUser($this->getUser()->getUserEntity());
		$this->redirectUrl($this->addTokenToUrl($this->back, $token->getToken()));
	}


	private function addTokenToUrl($url, $token)
	{
		return str_replace('__TOKEN__', $token, $url);
	}

}
