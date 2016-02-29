<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Line;
use GoClimb\Model\Entities\Sector;


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
