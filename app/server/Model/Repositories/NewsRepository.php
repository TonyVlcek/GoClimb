<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\News;
use GoClimb\Model\Entities\Wall;


class NewsRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return News|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}


	/**
	 * @param Wall $wall
	 * @param bool|NULL $published
	 * @return News[]
	 */
	public function getByWall(Wall $wall, $published = NULL)
	{
		return $this->getByWallOrNull($wall, $published);
	}

	/**
	 * @param bool|NULL $published
	 * @return News[]
	 */
	public function getGlobal($published = NULL)
	{
		return $this->getByWallOrNull(NULL, $published);
	}


	/**
	 * @param Wall|NULL $wall
	 * @param bool|NULL $published
	 * @return News[]
	 */
	private function getByWallOrNull(Wall $wall = NULL, $published = NULL)
	{
		if ($published === TRUE) {
			return $this->getDoctrineRepository()->findBy(["wall" => $wall, "publishedDate !=" => NULL]);
		} elseif ($published === FALSE) {
			return $this->getDoctrineRepository()->findBy(["wall" => $wall, "publishedDate" => NULL]);
		} else {
			return $this->getDoctrineRepository()->findBy(["wall" => $wall]);
		}
	}


	/**
	 * @param News $news
	 */
	public function remove(News $news)
	{
		$this->getEntityManager()->remove($news);
		$this->getEntityManager()->flush();
	}

}
