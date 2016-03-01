<?php

namespace GoClimb\UI\Forms;

use Kdyby\Translation\Translator;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Utils\ArrayHash;


abstract class BaseForm extends Control
{

	/** @var array */
	public $onSuccess = [];

	/** @var array */
	public $onValidate = [];

	/** @var Translator */
	protected $translator;


	public function __construct()
	{
		parent::__construct();
		$form = $this->getForm();
		$form->onValidate[] = function () {
			call_user_func_array([$this, 'onValidate'], func_get_args());
		};
		$form->onSuccess[] = function () {
			call_user_func_array([$this, 'onSuccess'], func_get_args());
		};
		$this->onValidate[] = function (Form $form) {
			$this->validateForm($form, $form->getValues());
		};
		$this->onSuccess[] = function (Form $form) {
			$this->formSuccess($form, $form->getValues());
		};
	}


	/**
	 * @param Form $form
	 */
	abstract public function init(Form $form);


	/**
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	abstract public function validateForm(Form $form, ArrayHash $values);


	/**
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	abstract public function formSuccess(Form $form, ArrayHash $values);


	/**
	 * @return string
	 */
	abstract public function getDomain();


	public function attached($presenter)
	{
		parent::attached($presenter);
		$this->init($this->getForm());
	}


	/**
	 * @param Translator $translator
	 */
	public function setTranslator(Translator $translator)
	{
		$this->translator = $translator->domain('forms.' . $this->getDomain());
		$this->getForm()->setTranslator($this->translator);
	}


	/**
	 * @return Form
	 */
	public function getForm()
	{
		return $this['form'];
	}


	/**
	 * @return Template
	 */
	public function getTemplate()
	{
		return parent::getTemplate();
	}


	public function render()
	{
		$file = rtrim($this->getReflection()->getFileName(), '.php') . '.latte';
		$template = $this->getTemplate();
		$template->setFile(file_exists($file) ? $file : __DIR__ . '/BaseForm.latte');
		$template->add('form', $form = $this->getForm());
		$template->render();
	}


	protected function createComponentForm()
	{
		return new Form;
	}

}
