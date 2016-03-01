<?php

namespace GoClimb\UI\Forms\Company;

use GoClimb\Model\Entities\Company;
use GoClimb\Model\Query\Specifications\Company\DuplicateName;
use GoClimb\Model\Repositories\CompanyRepository;
use GoClimb\UI\Forms\BaseBootstrapForm;
use GoClimb\UI\Forms\Form;
use GoClimb\UI\Forms\ITranslatableFormFactory;
use Nette\Utils\ArrayHash;


interface ICompanyFormFactory extends ITranslatableFormFactory
{

	/** @return CompanyForm */
	function create(Company $company);

}

class CompanyForm extends BaseBootstrapForm
{

	/** @var Company */
	private $company;

	/** @var CompanyRepository */
	private $companyRepository;


	public function __construct(Company $company, CompanyRepository $companyRepository)
	{
		parent::__construct();
		$this->company = $company;
		$this->companyRepository = $companyRepository;
	}


	/**
	 * @inheritdoc
	 */
	public function init(Form $form)
	{
		$form->addText('name', 'fields.name')
			->setAttribute('placeholder', 'fields.name')
			->setDefaultValue($this->company->getName());

		if ($this->company->getId()) {
			$form->addSubmit('save', 'fields.edit');
		} else {
			$form->addSubmit('save', 'fields.add');
		}
	}


	/**
	 * @inheritdoc
	 */
	public function validateForm(Form $form, ArrayHash $values)
	{
		if ($this->companyRepository->getResultByFilters(new DuplicateName($this->company, $values->name))) {
			$form['name']->addError('errors.name.duplicate');
		}
	}


	/**
	 * @inheritdoc
	 */
	public function formSuccess(Form $form, ArrayHash $values)
	{
		$company = $this->company;
		$company->setName($values->name);
		$this->companyRepository->save($company);
	}


	/**
	 * @inheritdoc
	 */
	public function getDomain()
	{
		return 'company.companyForm';
	}

}
