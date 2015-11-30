<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Model\Facades;

use OnlineClimbing\Model\Entities\RestToken;
use OnlineClimbing\Model\Entities\User;
use OnlineClimbing\Model\Entities\Wall;
use OnlineClimbing\Model\Repositories\RestTokenRepository;


class RestFacade
{

	/** @var RestTokenRepository */
	private $restTokenRepository;


	public function __construct(RestTokenRepository $restTokenRepository)
	{
		$this->restTokenRepository = $restTokenRepository;
	}


	/**
	 * @param string $token
	 * @param Wall $wall
	 * @param User $user
	 * @param string $ip
	 * @return bool
	 */
	public function validateToken($token, Wall $wall, User $user, $ip)
	{
		$restToken = $this->restTokenRepository->getRestToken($wall, $user, $ip);
		if ($restToken) {
			return $token === $restToken->getToken();
		} else {
			return FALSE;
		}
	}


	/**
	 * @param Wall $wall
	 * @param User $user
	 * @param string $ip
	 * @return RestToken
	 */
	public function getRestToken(Wall $wall, User $user, $ip)
	{
		if ($restToken = $this->restTokenRepository->getRestToken($wall, $user, $ip)) {
			return $restToken;
		} else {
			return $this->createRestToken($wall, $user, $ip);
		}
	}


	public function createRestToken(Wall $wall, User $user, $ip)
	{
		return $this->restTokenRepository->createRestToken($wall, $user, $ip);
	}

}
