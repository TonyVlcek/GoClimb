<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\File;


class FileRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return File|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}
}
