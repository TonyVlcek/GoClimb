<?php
/**
 * @author Filip Čáp
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\AclResource;


class AclResourceRepository extends BaseRepository
{

	/**
	 * @param string $name
	 * @return AclResource|NULL
	 */
	public function getByName($name)
	{
		return $this->getDoctrineRepository()->findOneBy(['name' => $name]);
	}

}
