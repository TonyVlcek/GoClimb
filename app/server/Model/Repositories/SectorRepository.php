<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Sector;
use GoClimb\Model\Entities\Wall;


class SectorRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return Sector|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}


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


	/**
	 * @param Wall $wall
	 * @param string $name
	 * @return Sector
	 */
	public function create(Wall $wall, $name)
	{
		$sector = new Sector;
		$this->save($sector->setWall($wall)->setName($name));
		return $sector;
	}

}
