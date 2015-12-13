<?php
/**
 * @author Ronald Luc
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\AclPrivilege;


class AclPrivilegeRepository extends BaseRepository
{

	/**
	 * @param string $name
	 * @return AclPrivilege|NULL
	 */
	public function getByName($name)
	{
		return $this->getDoctrineRepository()->findOneBy(["name" => $name]);
	}

}
