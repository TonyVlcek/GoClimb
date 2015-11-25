<?php
/**
 * @author Martin Mikšík
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\File;


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
