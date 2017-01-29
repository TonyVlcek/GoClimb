<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Rating;


class RatingRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return Rating|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}
}
