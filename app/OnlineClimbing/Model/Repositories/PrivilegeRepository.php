<?php
/**
 * @author Ronald Luc
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\Privilege;


class PrivilegeRepository extends BaseRepository
{

	/**
	 * @param string $name
	 * @return Privilege|NULL
	 */
	public function getByName($name)
	{
		return $this->getDoctrineRepository()->findOneBy(["name" => $name]);
	}

}
