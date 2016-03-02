<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Route;


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
