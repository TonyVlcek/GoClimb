<?php

namespace GoClimb\UI\Forms\User;

use GoClimb\UI\Forms\BaseForm;
use GoClimb\UI\Forms\Form;
use GoClimb\UI\Forms\ITranslatableFormFactory;
use Nette\Utils\ArrayHash;


interface IPasswordResetFormFactory extends ITranslatableFormFactory
{

	/** @return PasswordResetForm */
	function create();

}


class PasswordResetForm extends BaseForm
{

	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * @param Form $form
	 */
	public function init(Form $form)
	{
		$form->addPassword('password', 'fields.password')
			->setAttribute('placeholder', 'fields.password')
			->setRequired('errors.password.required');

		$form->addPassword('passwordCheck', 'fields.passwordCheck')
			->setAttribute('placeholder', 'fields.password')
			->setRequired('errors.password.required')
			->addRule(Form::EQUAL, 'errors.password.doesNotMatch', $form['password'])
			->setOmitted();

		$form->addSubmit('reset', 'fields.reset');
	}


	/**
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	public function validateForm(Form $form, ArrayHash $values)
	{

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
		return 'user.passwordReset';
	}
}
