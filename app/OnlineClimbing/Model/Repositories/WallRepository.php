<?php
/**
 * @author Martin Mikšík
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\Company;
use OnlineClimbing\Model\Entities\Wall;
use OnlineClimbing\Model\WallException;


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
}
