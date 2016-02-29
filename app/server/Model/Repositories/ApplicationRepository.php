<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Application;


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
