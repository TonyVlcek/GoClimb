<?php

namespace GoClimb\Modules\BackendModule;

use GoClimb\Model\Entities\Company;
use GoClimb\Model\Entities\User;
use GoClimb\UI\Controls\ICompanyEditControlFactory;
use GoClimb\UI\Forms\Company\ICompanyFormFactory;
use GoClimb\UI\Forms\Company\ICompanyMemberFormFactory;
use GoClimb\UI\Grids\Company\ICompanyGridFactory;


class CompanyPresenter extends BaseBackendPresenter
{

	/** @var ICompanyGridFactory */
	private $companyGridFactory;

	/** @var ICompanyFormFactory */
	private $companyFormFactory;

	/** @var ICompanyMemberFormFactory */
	private $companyMemberFormFactory;

	/** @var ICompanyEditControlFactory */
	private $companyEditControlFactory;

	/** @var Company|NULL */
	private $company;


	public function __construct(ICompanyGridFactory $companyGridFactory, ICompanyFormFactory $companyFormFactory, ICompanyMemberFormFactory $companyMemberForm, ICompanyEditControlFactory $companyEditControlFactory)
	{
		parent::__construct();
		$this->companyGridFactory = $companyGridFactory;
		$this->companyFormFactory = $companyFormFactory;
		$this->companyMemberFormFactory = $companyMemberForm;
		$this->companyEditControlFactory = $companyEditControlFactory;
	}


	public function actionEdit(Company $company)
	{
		$this->company = $company;
	}


	protected function createComponentCompanyGrid()
	{
		return $this->companyGridFactory->create();
	}


	protected function createComponentCompanyForm()
	{
		$form = $this->companyFormFactory->create(new Company);
		$form->onSuccess[] = [$this, 'companyCreated'];

		return $form;
	}


	protected function createComponentCompanyEditControl()
	{
		$component = $this->companyEditControlFactory->create($this->company);

		$component->getCompanyForm()->onSuccess[] = [$this, 'companyRenamed'];
		$component->getCompanyMemberForm()->onSuccess[] = [$this, 'userAdded'];
		$component->onUserRemoved[] = [$this, 'userRemoved'];

		return $component;
	}


	public function companyCreated()
	{
		$this->flashMessageSuccess('messages.company.created');
		$this->redirect('default');
	}


	public function companyRenamed()
	{
		$this->flashMessageSuccess('messages.company.renamed');
		$this->redirect('this');
	}

	public function userAdded()
	{
		$this->flashMessageSuccess('messages.user.added');
		$this->redirect('this');
	}


	public function userRemoved(User $user)
	{
		$this->flashMessageSuccess('messages.user.removed', ['email' => $user->getEmail()]);
		$this->redirect('this');
	}

}
