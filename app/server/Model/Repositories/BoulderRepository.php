<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Boulder;
use GoClimb\Model\Entities\Wall;


class BoulderRepository extends BaseRepository
{


	/**
	 * @param int $id
	 * @return Boulder|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}


	/**
	 * @param Wall $wall
	 * @return Boulder[]
	 */
	public function getByWall(Wall $wall)
	{
		return $this->getDoctrineRepository()->findBy([
			'line.sector.wall' => $wall,
		]);
	}

	/**
	 * @param Wall $wall
	 * @return Boulder[]
	 */
	public function getStandingByWall(Wall $wall)
	{
		return $this->getDoctrineRepository()->findBy([
			'line.sector.wall' => $wall,
			'dateRemoved' => NULL,
		]);
	}

	/**
	 * @param Boulder $boulder
	 */
	public function remove(Boulder $boulder)
	{
		$this->getEntityManager()->remove($boulder);
		$this->getEntityManager()->flush();
	}

}
