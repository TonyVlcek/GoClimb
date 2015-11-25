<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\Route;


class RouteRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return Route|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}
}
