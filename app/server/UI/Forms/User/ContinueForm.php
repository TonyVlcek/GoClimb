<?php

namespace GoClimb\UI\Forms\User;

use GoClimb\UI\Forms\BaseForm;
use GoClimb\UI\Forms\Form;
use GoClimb\UI\Forms\ITranslatableFormFactory;
use Nette\Utils\ArrayHash;


interface IContinueFormFactory extends ITranslatableFormFactory
{

	/** @return ContinueForm */
	function create();

}


class ContinueForm extends BaseForm
{

	/**
	 * @param Form $form
	 */
	public function init(Form $form)
	{
		$form->addCheckbox('remember', 'fields.remember');

		$form->addSubmit('continue', 'fields.continue');
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
		return 'user.continue';
	}
}
