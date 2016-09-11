<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Event;
use GoClimb\Model\Entities\Wall;


class EventRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return Event|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}


	/**
	 * @param Wall $wall
	 * @param bool|NULL $published
	 * @return Event[]
	 */
	public function getByWall(Wall $wall, $published = NULL)
	{
		return $this->getByWallOrNull($wall, $published);
	}

	/**
	 * @param bool|NULL $published
	 * @return Event[]
	 */
	public function getGlobal($published = NULL)
	{
		return $this->getByWallOrNull(NULL, $published);
	}


	/**
	 * @param Wall|NULL $wall
	 * @param bool|NULL $published
	 * @return Event[]
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
	 * @param Event $event
	 */
	public function remove(Event $event)
	{
		$this->getEntityManager()->remove($event);
		$this->getEntityManager()->flush();
	}

}
