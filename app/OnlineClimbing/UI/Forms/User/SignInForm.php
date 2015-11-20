<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\UI\Forms\User;

use Nette\Security\Identity;
use Nette\Security\Passwords;
use Nette\Security\User as SecurityUser;
use Nette\Utils\ArrayHash;
use OnlineClimbing\Model\Entities\User;
use OnlineClimbing\Model\Facades\UserFacade;
use OnlineClimbing\UI\Forms\BaseForm;
use OnlineClimbing\UI\Forms\Form;
use OnlineClimbing\UI\Forms\ITranslatableFormFactory;


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


	public function __construct(UserFacade $userFacade, SecurityUser $securityUser) // TODO own User
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
		$this->securityUser->login(new Identity($this->user->getId(), [], [])); // TODO own identity
	}


	/**
	 * @return string
	 */
	public function getDomain()
	{
		return 'user.signIn';
	}
}
