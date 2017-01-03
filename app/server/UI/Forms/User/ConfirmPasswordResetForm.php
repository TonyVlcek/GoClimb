<?php

namespace GoClimb\UI\Forms\User;

use GoClimb\Model\Entities\User;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\UI\Forms\BaseForm;
use GoClimb\UI\Forms\Form;
use GoClimb\UI\Forms\ITranslatableFormFactory;
use Nette\Utils\ArrayHash;


interface IConfirmPasswordResetFormFactory extends ITranslatableFormFactory
{

	/** @return ConfirmPasswordResetForm */
	function create();

}


class ConfirmPasswordResetForm extends BaseForm
{


	/** @var UserRepository */
	private $userRepository;


	/** @var User */
	private $user;


	public function __construct(UserRepository $userRepository)
	{
		parent::__construct();
		$this->userRepository = $userRepository;
	}


	/**
	 * @param Form $form
	 */
	public function init(Form $form)
	{
		$form->addEmail('email', 'fields.email');

		$form->addSubmit('reset', 'fields.reset');
	}


	/**
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	public function validateForm(Form $form, ArrayHash $values)
	{
		$email = $form->values['email'];
		if (!$this->user = $this->userRepository->getByEmail($email)) {
			$form['email']->addError($this->translator->translate('errors.email.notFound'));
		}
	}


	/**
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	public function formSuccess(Form $form, ArrayHash $values)
	{

	}


	/**
	 * @return string
	 */
	public function getDomain()
	{
		return 'user.confirmPasswordReset';
	}
}
