<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\Application;


class ApplicationRepository extends BaseRepository
{

	/**
	 * @param string $token
	 * @return Application|NULL
	 */
	public function getByToken($token)
	{
		return $this->getDoctrineRepository()->findOneBy(['token' => $token]);
	}

}
