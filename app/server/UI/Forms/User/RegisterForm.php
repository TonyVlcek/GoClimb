<?php

namespace GoClimb\UI\Forms\User;

use GoClimb\Model\Entities\User;
use GoClimb\Model\Facades\UserFacade;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Security\Identity;
use GoClimb\UI\Forms\BaseForm;
use GoClimb\UI\Forms\Form;
use GoClimb\UI\Forms\ITranslatableFormFactory;
use Nette\Utils\ArrayHash;


interface IRegisterFormFactory extends ITranslatableFormFactory
{

	/** @return RegisterForm */
	function create();
}


class RegisterForm extends BaseForm
{

	/** @var UserFacade */
	private $userFacade;

	/** @var UserRepository */
	private $userRepository;


	public function __construct(UserFacade $userFacade, UserRepository $userRepository)
	{
		parent::__construct();
		$this->userFacade = $userFacade;
		$this->userRepository = $userRepository;
	}


	/**
	 * @param Form $form
	 */
	public function init(Form $form)
	{
		$form->addText('email', 'fields.email')
			->setType('email')
			->setAttribute('placeholder', 'fields.email')
			->addRule(Form::EMAIL, 'errors.email.invalid')
			->setRequired('errors.email.required');

		$form->addPassword('password', 'fields.password')
			->setAttribute('placeholder', 'fields.password')
			->setRequired('errors.password.required');

		$form->addPassword('passwordCheck', 'fields.passwordCheck')
			->setAttribute('placeholder', 'fields.password')
			->setRequired('errors.password.required')
			->addRule(Form::EQUAL, 'errors.password.doesNotMatch', $form['password'])
			->setOmitted();

		$form->addText('nick', 'fields.nick')
			->setRequired(FALSE)
			->setAttribute('placeholder', 'fields.nick')
			->addCondition(Form::FILLED)
				->addRule(Form::PATTERN, 'errors.nick.invalid', '[a-zA-Z0-9_\-]{3,255}');

		$form->addSubmit('register', 'fields.register');
	}


	/**
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	public function validateForm(Form $form, ArrayHash $values)
	{
		if ($values->nick && $this->userRepository->getByNick($values->nick)) {
			$form['nick']->addError($this->translator->translate('errors.nick.registered'));
		}

		if ($this->userRepository->getByEmail($values->email)) {
			$form['email']->addError($this->translator->translate('errors.email.registered'));
		}
	}


	/**
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	public function formSuccess(Form $form, ArrayHash $values)
	{
		$user = $this->userFacade->registerUser($values->email, $values->password);

		if ($values->nick) {
			$user->setNick($values->nick);
		}
		$this->userRepository->save($user);
	}


	/**
	 * @return string
	 */
	public function getDomain()
	{
		return 'user.register';
	}
}
