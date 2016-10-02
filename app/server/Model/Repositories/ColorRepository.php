<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Color;


class ColorRepository extends ReadonlyRepository
{


	/**
	 * @param string $hash
	 * @return Color|NULL
	 */
	public function getGlobalByHash($hash)
	{
		return $this->getDoctrineRepository()->findOneBy(['hash' => $hash, 'wall' => NULL]);
	}


	/**
	 * @return Color[]
	 */
	public function getGlobal()
	{
		return $this->getDoctrineRepository()->findBy(['wall' => NULL]);
	}

}
