<?php
/**
 * @author Martin Mikšík
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\Image;


class ImageRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return Image|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}
}
