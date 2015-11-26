<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\Company;


class CompanyRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return Company|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}

}
