<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\UI\Forms\Company;

use Nette\Utils\ArrayHash;
use OnlineClimbing\Model\Entities\Company;
use OnlineClimbing\Model\Entities\User;
use OnlineClimbing\Model\Repositories\CompanyRepository;
use OnlineClimbing\Model\Repositories\UserRepository;
use OnlineClimbing\UI\Forms\BaseForm;
use OnlineClimbing\UI\Forms\Form;
use OnlineClimbing\UI\Forms\ITranslatableFormFactory;


interface ICompanyMemberFormFactory extends ITranslatableFormFactory
{

	/** @return CompanyMemberForm */
	function create(Company $company);

}


class CompanyMemberForm extends BaseForm
{

	/** @var CompanyRepository */
	private $companyRepository;

	/** @var UserRepository */
	private $userRepository;

	/** @var Company */
	private $company;


	public function __construct(Company $company, CompanyRepository $companyRepository, UserRepository $userRepository)
	{
		parent::__construct();
		$this->companyRepository = $companyRepository;
		$this->userRepository = $userRepository;
		$this->company = $company;
	}


	/**
	 * @param Form $form
	 */
	public function init(Form $form)
	{

		//TODO: Make the IFilter solution work

		/** @var User[] $members */
		$members = $this->userRepository->getResultByFilters(); //Temporary solution

		$selectMembers = [];
		foreach ($members as $member) {
			$selectMembers[$member->getId()] = $member->getName();
		}

		$form->addSelect('member', $this->translator->translate('fields.member'), $selectMembers)->setTranslator(NULL); //TODO: Special input type (own)
		$form->addSubmit('add', 'fields.submit');
	}


	/**
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	public function validateForm(Form $form, ArrayHash $values)
	{
		if (!$this->userRepository->getById($values['member'])) {
			$form['name']->addError('errors.memberNotExists');
		}
	}


	/**
	 * @param Form $form
	 * @param ArrayHash $values
	 */
	public function formSuccess(Form $form, ArrayHash $values)
	{
		$member = $this->userRepository->getById($values['member']);
		$this->companyRepository->addMember($member, $this->company);
	}


	/**
	 * @return string
	 */
	public function getDomain()
	{
		return 'company.memberForm';
	}
}
