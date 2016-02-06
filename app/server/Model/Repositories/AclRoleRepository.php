<?php
/**
 * @author Martin Mikšík
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\AclRole;
use GoClimb\Model\Entities\Wall;


class AclRoleRepository extends BaseRepository
{

	/**
	 * @param Wall $wall
	 * @return AclRole[]
	 */
	public function getByWall(Wall $wall)
	{
		return $this->getDoctrineRepository()->findBy(["wall" => $wall]);
	}


	/**
	 * @return AclRole[]
	 */
	public function getGlobal()
	{
		return $this->getDoctrineRepository()->findBy(["wall" => NULL]);
	}


	/**
	 * @param string $name
	 * @param Wall $wall
	 * @return AclRole|NULL
	 */
	public function getByName($name, Wall $wall)
	{
		return $this->getDoctrineRepository()->findOneBy(["name" => $name, "wall" => $wall]);
	}


	/**
	 * @param string $name
	 * @return AclRole|NULL
	 */
	public function getGlobalByName($name)
	{
		return $this->getDoctrineRepository()->findOneBy(["name" => $name, "wall" => NULL]);
	}
}
