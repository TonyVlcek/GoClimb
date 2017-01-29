<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Rope;
use GoClimb\Model\Entities\Wall;


class RopeRepository extends BaseRepository
{


	/**
	 * @param int $id
	 * @return Rope|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}


	/**
	 * @param Wall $wall
	 * @return Rope[]
	 */
	public function getByWall(Wall $wall)
	{
		return $this->getDoctrineRepository()->findBy([
			'line.sector.wall' => $wall,
		]);
	}


	/**
	 * @param Wall $wall
	 * @return Rope[]
	 */
	public function getStandingByWall(Wall $wall)
	{
		return $this->getDoctrineRepository()->findBy([
			'line.sector.wall' => $wall,
			'dateRemoved' => NULL,
		]);
	}


	/**
	 * @param Rope $rope
	 */
	public function remove(Rope $rope)
	{
		$this->getEntityManager()->remove($rope);
		$this->getEntityManager()->flush();
	}

}
