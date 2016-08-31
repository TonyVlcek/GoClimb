<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\CurrentNews;
use GoClimb\Model\Entities\Wall;


class CurrentNewsRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return CurrentNews|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}


	/**
	 * @param Wall $wall
	 * @param bool|NULL $published
	 * @return CurrentNews[]
	 */
	public function getByWall(Wall $wall, $published = NULL)
	{
		return $this->getByWallOrNull($wall, $published);
	}

	/**
	 * @param bool|NULL $published
	 * @return CurrentNews[]
	 */
	public function getGlobal($published = NULL)
	{
		return $this->getByWallOrNull(NULL, $published);
	}


	/**
	 * @param Wall|NULL $wall
	 * @param bool|NULL $published
	 * @return CurrentNews[]
	 */
	private function getByWallOrNull(Wall $wall = NULL, $published = NULL)
	{
		if ($published === TRUE) {
			return $this->getDoctrineRepository()->findBy(["wall" => $wall, "published !=" => NULL]);
		} elseif ($published === FALSE) {
			return $this->getDoctrineRepository()->findBy(["wall" => $wall, "published" => NULL]);
		} else {
			return $this->getDoctrineRepository()->findBy(["wall" => $wall]);
		}
	}


	/**
	 * @param CurrentNews $currentNews
	 */
	public function remove(CurrentNews $currentNews)
	{
		$this->getEntityManager()->remove($currentNews);
		$this->getEntityManager()->flush();
	}

}
