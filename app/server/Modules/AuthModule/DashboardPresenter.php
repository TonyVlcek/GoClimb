<?php

namespace GoClimb\Modules\AuthModule;

use GoClimb\Model\Entities\Application;
use GoClimb\Model\Entities\LoginToken;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Facades\AuthFacade;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\UI\Forms\Form;
use GoClimb\UI\Forms\User\IConfirmPasswordResetFormFactory;
use GoClimb\UI\Forms\User\IContinueFormFactory;
use GoClimb\UI\Forms\User\IPasswordResetFormFactory;
use GoClimb\UI\Forms\User\IRegisterFormFactory;
use GoClimb\UI\Forms\User\ISignInFormFactory;
use Latte\Engine;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Security\Passwords;
use Nette\Bridges\ApplicationLatte\ILatteFactory;


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

	/** @var IRegisterFormFactory */
	private $registerFormFactory;

	/** @var AuthFacade */
	private $authFacade;

	/** @var IConfirmPasswordResetFormFactory */
	private $confirmPasswordResetFormFactory;

	/** @var IPasswordResetFormFactory */
	private $passwordResetFormFactory;

	/** @var UserRepository */
	private $userRepository;

	/** @var IMailer */
	private $mailer;

	/** @var Engine */
	private $engine;

	/** @var User */
	private $userForReset;


	public function __construct(ISignInFormFactory $signInFormFactory, IContinueFormFactory $continueFormFactory, IRegisterFormFactory $registerFormFactory, AuthFacade $authFacade, UserRepository $userRepository, IMailer $mailer, ILatteFactory $latteFactory, IConfirmPasswordResetFormFactory $confirmPasswordResetFormFactory, IPasswordResetFormFactory $passwordResetFormFactory)
	{
		parent::__construct();
		$this->signInFormFactory = $signInFormFactory;
		$this->continueFormFactory = $continueFormFactory;
		$this->registerFormFactory = $registerFormFactory;
		$this->authFacade = $authFacade;
		$this->userRepository = $userRepository;
		$this->mailer = $mailer;
		$this->engine = $latteFactory->create();
		$this->confirmPasswordResetFormFactory = $confirmPasswordResetFormFactory;
		$this->passwordResetFormFactory = $passwordResetFormFactory;
	}


	public function actionRegister($back)
	{
		$this->template->back = $this->addTokenToUrl($back, NULL);
	}


	public function actionLogin($back)
	{
		$this->template->back = $this->addTokenToUrl($back, NULL);
		$this->back = $back;

		if ($this->user->isLoggedIn()) {
			$this->setView('continue');
		}
	}


	public function actionLogout($back)
	{
		$this->user->logout(TRUE);
		$this->redirectUrl($back);
	}


	public function actionReset($back, $hash)
	{
		$this->template->back = $this->addTokenToUrl($back, NULL);
		$this->back = $back;

		$this->userForReset = $this->userRepository->getByPasswordReset($hash);

		if (!$this->userForReset || !$this->userForReset->getPasswordReset()) {
			$this->flashMessageError('user.passwordReset.invalidHash');
			$this->redirect('confirm');
		}
	}


	public function actionConfirm($back)
	{
		$this->template->back = $this->addTokenToUrl($back, NULL);
	}


	public function renderLogin(Application $application)
	{
		$this->template->application = $application;
		$this->template->isGoClimb = $application->getToken() === Application::APP_TOKEN;
	}


	public function renderContinue(Application $application)
	{
		$this->template->application = $application;
		$this->template->isGoClimb = $application->getToken() === Application::APP_TOKEN;
	}


	public function renderRegister(Application $application)
	{
		$this->template->application = $application;
		$this->template->isGoClimb = $application->getToken() === Application::APP_TOKEN;
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


	protected function createComponentRegisterForm()
	{
		$form = $this->registerFormFactory->create();
		$form->onSuccess[] = function () {
			$this->flashMessageSuccess('user.register.success');
			$this->redirect('login');
		};
		return $form;
	}


	protected function createComponentConfirmResetForm()
	{
		$form = $this->confirmPasswordResetFormFactory->create();
		$form->onSuccess[] = [$this, 'sendResetLink'];
		return $form;
	}


	protected function createComponentResetForm()
	{
		$form = $this->passwordResetFormFactory->create();
		$form->onSuccess[] = [$this, 'resetPassword'];
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


	public function sendResetLink(Form $form)
	{
		$user = $this->userRepository->getByEmail($form->values['email']);

		$hash = $user->getId() . uniqid();
		$user->setPasswordReset($hash);

		$mail = new Message;
		$mail->setSubject($this->translator->translate('emails.passwordReset.title'));
		//TODO: Email?
		$mail->setFrom('noreply@goclimb.cz', 'GoClimb');
		$mail->addTo($user->getEmail(), $user->getFullName());

		$link = $this->link("//:Auth:Dashboard:reset", ['back' => $this->back, 'hash' => $hash]);

		$mail->setHtmlBody($this->engine->renderToString(__DIR__ . '/templates/passwordResetEmail.latte', ['link' => $link]));

		$this->userRepository->save($user);
		$this->mailer->send($mail);

		$this->flashMessageSuccess('user.passwordResetConfirm.success');
		$this->redirect('Dashboard:login', ['back' => $this->back]);
	}


	public function resetPassword(Form $form)
	{
		$this->userForReset->setPasswordReset(NULL);
		$this->userForReset->setPassword(Passwords::hash($form->values['password']));
		$this->userRepository->save($this->userForReset);

		$this->flashMessageSuccess('user.passwordReset.success');
		$this->redirect('Dashboard:login', ['back' => $this->back]);
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
