<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Difficulty;


class DifficultyRepository extends ReadonlyRepository
{


	/**
	 * @param int $id
	 * @return Difficulty|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}


	/**
	 * @return Difficulty[]
	 */
	public function getAll()
	{
		return $this->getDoctrineRepository()->findAll();
	}

}
