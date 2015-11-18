<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\Article;
use OnlineClimbing\Model\Entities\Wall;


class ArticleRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return Article|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}


	/**
	 * @param Wall $wall
	 * @param bool|NULL $published
	 * @return Article[]
	 */
	public function getByWall(Wall $wall, $published = NULL)
	{
		return $this->getByWallOrNull($wall, $published);
	}

	/**
	 * @param bool|NULL $published
	 * @return Article[]
	 */
	public function getGlobal($published = NULL)
	{
		return $this->getByWallOrNull(NULL, $published);
	}


	/**
	 * @param Wall|NULL $wall
	 * @param bool|NULL $published
	 * @return Article[]
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

}
