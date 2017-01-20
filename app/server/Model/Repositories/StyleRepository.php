<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Style;


class StyleRepository extends BaseRepository
{

	/**
	 * @return Style[]
	 */
	public function getAll()
	{
		return $this->getDoctrineRepository()->findAll();
	}

	/**
	 * @param String $names
	 * @return Style[]
	 */
	public function getExpect($names)
	{
		if ($names === []){
			$names = NULL;
		}

		return $this->getDoctrineRepository()->findBy(['name NOT IN' => $names]);
	}


	/**
	 * @param int $id
	 * @return Style|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}

}
