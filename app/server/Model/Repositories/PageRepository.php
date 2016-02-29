<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Page;


class PageRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return Page|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}

}
