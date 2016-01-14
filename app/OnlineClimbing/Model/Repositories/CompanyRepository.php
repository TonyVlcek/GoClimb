<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\Company;
use OnlineClimbing\Model\Entities\User;


class CompanyRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return Company|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}


	/**
	 * @param string $name
	 * @return Company|NULL
	 */
	public function getByName($name)
	{
		return $this->getDoctrineRepository()->findOneBy(['name' => $name]);
	}


	/**
	 * @param User $member
	 * @param Company $company
	 */
	public function addMember(User $member, Company $company)
	{
		$member->addCompany($company);
		$company->addUser($member);
		$this->getEntityManager()
			->persist([$member, $company])
			->flush();
	}


	/**
	 * @param User $member
	 * @param Company $company
	 */
	public function removeMember(User $member, Company $company)
	{
		$member->removeCompany($company);
		$company->removeUser($member);
		$this->getEntityManager()
			->persist([$member, $company])
			->flush();
	}

}
