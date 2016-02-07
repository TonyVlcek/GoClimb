<?php
/**
 * @author Tony Vlček
 */

namespace GoClimb\Model\Facades;

use GoClimb\Model\Entities\RestToken;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\Repositories\RestTokenRepository;


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
