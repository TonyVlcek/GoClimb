<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\UI\Forms\Company;

use Nette\Utils\ArrayHash;
use OnlineClimbing\Model\Entities\Company;
use OnlineClimbing\Model\Query\Specifications\Company\DuplicateName;
use OnlineClimbing\Model\Repositories\CompanyRepository;
use OnlineClimbing\UI\Forms\BaseForm;
use OnlineClimbing\UI\Forms\Form;
use OnlineClimbing\UI\Forms\ITranslatableFormFactory;


interface ICompanyFormFactory extends ITranslatableFormFactory
{

	/** @return CompanyForm */
	function create(Company $company);

}

class CompanyForm extends BaseForm
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
