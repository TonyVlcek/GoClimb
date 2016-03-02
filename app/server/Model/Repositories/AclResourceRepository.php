<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\AclResource;


class AclResourceRepository extends BaseRepository
{

	/**
	 * @param string $name
	 * @return AclResource|NULL
	 */
	public function getByName($name)
	{
		return $this->getDoctrineRepository()->findOneBy(['name' => $name]);
	}


	/**
	 * @return AclResource[]
	 */
	public function getAll()
	{
		return $this->getDoctrineRepository()->findAll();
	}

}
