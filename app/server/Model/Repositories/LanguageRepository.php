<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Language;


class LanguageRepository extends BaseRepository
{

	/**
	 * @return Language[]
	 */
	public function getAll()
	{
		return $this->getDoctrineRepository()->findAll();
	}


	/**
	 * @param int $id
	 * @return Language|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}

}
