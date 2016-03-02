<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\AclPrivilege;


class AclPrivilegeRepository extends BaseRepository
{

	/**
	 * @param string $name
	 * @return AclPrivilege|NULL
	 */
	public function getByName($name)
	{
		return $this->getDoctrineRepository()->findOneBy(["name" => $name]);
	}


	/**
	 * @return AclPrivilege[]
	 */
	public function getAll()
	{
		return $this->getDoctrineRepository()->findAll();
	}

}
