<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Line;
use GoClimb\Model\Entities\Sector;


class LineRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return Line|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}


	/**
	 * @param string $name
	 * @param Sector $sector
	 * @return Line|NULL
	 */
	public function getByName($name, Sector $sector)
	{
		return $this->getDoctrineRepository()->findOneBy(["name" => $name, "sector" => $sector]);
	}


	/**
	 * @param Sector $sector
	 * @param string $name
	 * @return Line
	 */
	public function create(Sector $sector, $name)
	{
		$line = new Line;
		$this->save($line->setSector($sector)->setName($name));
		return $line;
	}

}
