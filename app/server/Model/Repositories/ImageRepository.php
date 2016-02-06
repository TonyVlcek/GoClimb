<?php
/**
 * @author Martin Mikšík
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Image;


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
