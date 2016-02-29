<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\AuthModule;

use GoClimb\UI\Forms\User\ISignInFormFactory;


final class DashboardPresenter extends BaseAuthPresenter
{

	/** @var string @persistent */
	public $back;

	/** @var string @persistent */
	public $token;

	/** @var ISignInFormFactory */
	private $signInFormFactory;


	public function __construct(ISignInFormFactory $signInFormFactory)
	{
		parent::__construct();
		$this->signInFormFactory = $signInFormFactory;
	}


	public function actionLogin($back)
	{
		$this->back = $back;

		if ($this->user->isLoggedIn()) {
			$this->redirectLoggedUser();
		}
	}


	public function actionLogout($back)
	{
		$this->user->logout(TRUE);
		$this->redirectUrl($back);
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
