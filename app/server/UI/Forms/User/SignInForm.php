<?php

namespace GoClimb\UI\Forms\User;

use GoClimb\Model\Entities\User;
use GoClimb\Model\Facades\UserFacade;
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

	/** @var UserFacade */
	private $userFacade;

	/** @var SecurityUser */
	private $securityUser;

	/** @var User */
	private $user;


	public function __construct(UserFacade $userFacade, SecurityUser $securityUser)
	{
		parent::__construct();
		$this->userFacade = $userFacade;
		$this->securityUser = $securityUser;
	}


	/**
	 * @param Form $form
	 */
	public function init(Form $form)
	{
		$form->addText('name', 'fields.name')
			->setRequired('errors.name.required');

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
		$this->user = $this->userFacade->getByName($values->name);
		if (!$this->user) {
			$form['name']->addError($this->translator->translate('errors.name.notFound'));
		} elseif (!Passwords::verify($values->password, $this->user->getPassword())) {
			$form['password']->addError($this->translator->translate('errors.password.invalid'));
		}
	}


	/**
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	public function formSuccess(Form $form, ArrayHash $values)
	{
		$this->securityUser->login(new Identity($this->user));
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
