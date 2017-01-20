<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Log;
use GoClimb\Model\Entities\Route;
use GoClimb\Model\Entities\User;


class LogRepository extends BaseRepository
{

	/**
	 * @param User $user
	 * @param Route $route
	 * @return Log|NULL
	 */
	public function getByUserAndRoute(User $user, $route)
	{
		return $this->getDoctrineRepository()->findBy(["user" => $user, "route" => $route]);
	}

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
