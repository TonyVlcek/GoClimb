<?php

namespace GoClimb\UI\Forms\User;

use GoClimb\Model\Entities\User;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Security\Identity;
use GoClimb\Security\User as SecurityUser;
use GoClimb\UI\Forms\BaseForm;
use GoClimb\UI\Forms\Form;
use GoClimb\UI\Forms\ITranslatableFormFactory;
use Nette\Security\Passwords;
use Nette\Utils\ArrayHash;


interface ISignInFormFactory extends ITranslatableFormFactory
{

	/** @return SignInForm */
	function create();
}


class SignInForm extends BaseForm
{

	/** @var UserRepository */
	private $userRepository;

	/** @var SecurityUser */
	private $securityUser;

	/** @var User */
	private $user;


	public function __construct(UserRepository $userRepository, SecurityUser $securityUser)
	{
		parent::__construct();
		$this->userRepository = $userRepository;
		$this->securityUser = $securityUser;
	}


	/**
	 * @param Form $form
	 */
	public function init(Form $form)
	{
		$form->addText('login', 'fields.login')
			->setRequired('errors.login.required')
			->setAttribute('autofocus');

		$form->addPassword('password', 'fields.password')
			->setRequired('errors.password.required');

		$form->addCheckbox('remember', 'fields.remember');

		$form->addSubmit('submit', 'fields.submit');
	}


	/**
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	public function validateForm(Form $form, ArrayHash $values)
	{
		$user = $this->userRepository->getByName($values->login);

		if (!$user) {
			$user = $this->userRepository->getByEmail($values->login);
		}

		if (!$user) {
			$form['login']->addError($this->translator->translate('errors.login.notFound'));
		} elseif (!Passwords::verify($values->password, $user->getPassword())) {
			$form['password']->addError($this->translator->translate('errors.password.invalid'));
		} else {
			$this->user = $user;
		}

	}


	/**
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	public function formSuccess(Form $form, ArrayHash $values)
	{
		$this->securityUser->login(new Identity($this->user));
		$this->securityUser->setExpiration('+48 hours', FALSE, TRUE);
	}


	/**
	 * @return string
	 */
	public function getDomain()
	{
		return 'user.signIn';
	}


	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

}
