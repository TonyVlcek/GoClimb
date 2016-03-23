<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\AclPermission;


class AclPermissionRepository extends BaseRepository
{

	/**
	 * @return AclPermission[]
	 */
	public function getAll()
	{
		return $this->getDoctrineRepository()->findAll();
	}

}
