<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Company;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\WallException;


class WallRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return Wall|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}


	/**
	 * @param string $name
	 * @return Wall|NULL
	 */
	public function getByName($name)
	{
		return $this->getDoctrineRepository()->findOneBy(['name' => $name]);
	}


	/**
	 * @return Wall[]
	 */
	public function getAll()
	{
		return $this->getDoctrineRepository()->findAll();
	}


	/**
	 * @param Company $company
	 * @param string $name
	 * @return Wall
	 * @throws WallException
	 */
	public function createWall(Company $company, $name)
	{
		if ($this->getByName($name)) {
			throw WallException::duplicateName($name);
		}

		$wall = new Wall();
		$wall->setName($name);
		$wall->setCompany($company);

		$this->getEntityManager()
			->persist($wall)
			->flush($wall);

		return $wall;
	}


	/**
	 * @param User $user
	 * @return Wall[]
	 */
	public function getUsersAdmin(User $user)
	{
		$qb = $this->getBuilderByFilters();
		$qb->innerJoin('e.roles', 'roles')
			->innerJoin('roles.users', 'users')
			->where('users.id = :user_id')
			->setParameter('user_id', $user->getId());

		return $qb->getQuery()->getResult();
	}
}
