<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\ContentPart;


class ContentPartRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return ContentPart|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}
}
