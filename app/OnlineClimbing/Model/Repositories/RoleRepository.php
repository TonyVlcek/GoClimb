<?php
/**
 * @author Martin Mikšík
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\Role;
use OnlineClimbing\Model\Entities\Wall;


class RoleRepository extends BaseRepository
{

	/**
	 * @param Wall $wall
	 * @return Role[]
	 */
	public function getByWall(Wall $wall)
	{
		return $this->getDoctrineRepository()->findBy(["wall" => $wall]);
	}


	/**
	 * @return Role[]
	 */
	public function getGlobal()
	{
		return $this->getDoctrineRepository()->findBy(["wall" => NULL]);
	}


	/**
	 * @param string $name
	 * @param Wall $wall
	 * @return Role|NULL
	 */
	public function getByName($name, Wall $wall)
	{
		return $this->getDoctrineRepository()->findOneBy(["name" => $name, "wall" => $wall]);
	}


	/**
	 * @param string $name
	 * @return Role|NULL
	 */
	public function getGlobalByName($name)
	{
		return $this->getDoctrineRepository()->findOneBy(["name" => $name, "wall" => NULL]);
	}
}
