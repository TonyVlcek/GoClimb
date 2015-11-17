<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\Sector;
use OnlineClimbing\Model\Entities\Wall;


class SectorRepository extends BaseRepository
{

	/**
	 * @param Wall $wall
	 * @param string $name
	 * @return Sector|NULL
	 */
	public function getByName(Wall $wall, $name)
	{
		return $this->getDoctrineRepository()->findOneBy(["wall" => $wall, "name" => $name]);
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
