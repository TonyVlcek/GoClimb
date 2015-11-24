<?php
/**
 * @author Martin Mikšík
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\Line;
use OnlineClimbing\Model\Entities\Sector;


class LineRepository extends BaseRepository
{

	/**
	 * @param string $name
	 * @param Sector $sector
	 * @return Line|NULL
	 */
	public function getByName($name, Sector $sector)
	{
		return $this->getDoctrineRepository()->findOneBy(["name" => $name, "sector" => $sector]);
	}

}
