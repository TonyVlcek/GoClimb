<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Parameter;


class ParameterRepository extends ReadonlyRepository
{


	/**
	 * @return Parameter[]
	 */
	public function getAll()
	{
		return $this->getDoctrineRepository()->findAll();
	}


	/**
	 * @param string $name
	 * @return Parameter|NULL
	 */
	public function getByName($name)
	{
		return $this->getDoctrineRepository()->findOneBy(['name' => $name]);
	}

}
