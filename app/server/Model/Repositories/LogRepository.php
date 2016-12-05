<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Log;


class LogRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return Log|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}


	/**
	 * @return Log[]
	 */
	public function getAll()
	{
		return $this->getDoctrineRepository()->findBy([], ['loggedDate' => 'DESC']);
	}
}
