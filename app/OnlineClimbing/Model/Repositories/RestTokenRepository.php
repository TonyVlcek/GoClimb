<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\RestToken;
use OnlineClimbing\Model\Entities\User;
use OnlineClimbing\Model\Entities\Wall;


class RestTokenRepository extends BaseRepository
{

	/**
	 * @param Wall $wall
	 * @param User $user
	 * @param string $ip
	 * @return RestToken|NULL
	 */
	public function getRestToken(Wall $wall, User $user, $ip)
	{
		return $this->getDoctrineRepository()->findOneBy(["wall" => $wall, "user" => $user, "remote_ip" => $ip]);
	}

}
