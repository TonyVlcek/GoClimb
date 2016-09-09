<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\AclPermission;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;


class AclPermissionRepository extends BaseRepository
{

	/**
	 * @return AclPermission[]
	 */
	public function getAll()
	{
		return $this->getDoctrineRepository()->findAll();
	}


	/**
	 * @param User $user
	 * @param Wall|NULL $wall
	 * @return AclPermission[]
	 */
	public function getForUser(User $user, Wall $wall = NULL)
	{
		return $this->getDoctrineRepository()->findBy([
			'user' => $user,
			'wall' => $wall,
		]);
	}

}
