<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\UI\Controls;

use GoClimb\Model\Entities\Company;
use GoClimb\Model\Repositories\CompanyRepository;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\UI\Forms\Company\ICompanyFormFactory;
use GoClimb\UI\Forms\Company\ICompanyMemberFormFactory;
use GoClimb\UI\UserException;


interface ICompanyEditControlFactory extends ITranslatableControlFactory
{

	/** @return CompanyEditControl */
	function create(Company $company);

}

class CompanyEditControl extends BaseControl
{

	/** @var CompanyRepository */
	private $companyRepository;

	/** @var UserRepository */
	private $userRepository;

	/** @var ICompanyFormFactory */
	private $companyFormFactory;

	/** @var ICompanyMemberFormFactory */
	private $companyMemberFormFactory;

	/** @var Company */
	private $company;

	/** @var  array */
	public $onUserRemoved;


	public function __construct(Company $company, CompanyRepository $companyRepository, UserRepository $userRepository, ICompanyFormFactory $companyFormFactory, ICompanyMemberFormFactory $companyMemberFormFactory)
	{
		parent::__construct();
		$this->companyRepository = $companyRepository;
		$this->userRepository = $userRepository;
		$this->companyFormFactory = $companyFormFactory;
		$this->companyMemberFormFactory = $companyMemberFormFactory;
		$this->company = $company;
	}


	public function render()
	{
		$this->template->members = $this->company->getUsers();
		parent::render();
	}


	public function handleRemoveUser($id)
	{
		$member = $this->userRepository->getById($id);
		if (!$member) {
			throw UserException::notExisting($id);
		}
		$this->companyRepository->removeMember($member, $this->company);
		$this->onUserRemoved($member);
	}


	protected function createComponentCompanyForm()
	{
		return $this->companyFormFactory->create($this->company);
	}


	protected function createComponentCompanyMemberForm()
	{
		return $this->companyMemberFormFactory->create($this->company);
	}


	/**
	 * @inheritdoc
	 */
	public function getDomain()
	{
		return 'company.companyEditControl';
	}


	public function getCompanyForm()
	{
		return $this->getComponent("companyForm");
	}

	public function getCompanyMemberForm()
	{
		return $this->getComponent("companyMemberForm");
	}

}
