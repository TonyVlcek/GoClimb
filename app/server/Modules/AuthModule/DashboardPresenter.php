<?php

namespace GoClimb\Modules\AuthModule;

use GoClimb\Model\Entities\Application;
use GoClimb\Model\Entities\LoginToken;
use GoClimb\Model\Facades\AuthFacade;
use GoClimb\UI\Forms\Form;
use GoClimb\UI\Forms\User\IContinueFormFactory;
use GoClimb\UI\Forms\User\ISignInFormFactory;


final class DashboardPresenter extends BaseAuthPresenter
{

	/** @var string @persistent */
	public $back;

	/** @var string @persistent */
	public $token;

	/** @var ISignInFormFactory */
	private $signInFormFactory;

	/** @var IContinueFormFactory */
	private $continueFormFactory;

	/** @var AuthFacade */
	private $authFacade;


	public function __construct(ISignInFormFactory $signInFormFactory, IContinueFormFactory $continueFormFactory, AuthFacade $authFacade)
	{
		parent::__construct();
		$this->signInFormFactory = $signInFormFactory;
		$this->continueFormFactory = $continueFormFactory;
		$this->authFacade = $authFacade;
	}


	public function actionLogin($back)
	{
		$this->back = $back;

		if ($this->user->isLoggedIn()) {
			$this->setView('continue');
		}
	}


	public function renderLogin(Application $application)
	{
		$this->template->application = $application;
	}


	public function renderContinue(Application $application)
	{
		$this->template->application = $application;
	}


	public function actionLogout($back)
	{
		$this->user->logout(TRUE);
		$this->redirectUrl($back);
	}


	protected function createComponentSignInForm()
	{
		$form = $this->signInFormFactory->create();
		$form->onSuccess[] = [$this, 'loginUser'];
		return $form;
	}


	protected function createComponentContinueForm()
	{
		$form = $this->continueFormFactory->create();
		$form->onSuccess[] = [$this, 'continueFormSuccess'];
		return $form;
	}


	public function loginUser(Form $form)
	{
		$values = $form->getValues();
		$token = $this->authFacade->getLoginTokenForUser($this->getUser()->getUserEntity(), $values->remember);
		$this->redirectLoggedUser($token);
	}


	public function continueFormSuccess(Form $form)
	{
		$values = $form->getValues();
		$token = $this->authFacade->getLoginTokenForUser($this->getUser()->getUserEntity(), $values->remember);
		$this->redirectLoggedUser($token);
	}


	/**
	 * @param LoginToken $token
	 */
	public function redirectLoggedUser(LoginToken $token)
	{
		$this->redirectUrl($this->addTokenToUrl($this->back, $token->getToken()));
	}


	/**
	 * @param string $url
	 * @param string $token
	 * @return string
	 */
	private function addTokenToUrl($url, $token)
	{
		return str_replace($this::TOKEN_PLACEHOLDER, $token, $url);
	}

}
