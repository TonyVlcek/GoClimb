<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Sector;
use GoClimb\Model\Entities\Wall;


class SectorRepository extends BaseRepository
{

	/**
	 * @param string $name
	 * @param Wall $wall
	 * @return Sector|NULL
	 */
	public function getByName($name, Wall $wall)
	{
		return $this->getDoctrineRepository()->findOneBy(["name" => $name, "wall" => $wall]);
	}


	/**
	 * @param Wall $wall
	 * @return Sector[]
	 */
	public function getByWall(Wall $wall)
	{
		return $this->getDoctrineRepository()->findBy(["wall" => $wall]);
	}
}
