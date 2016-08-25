<?php

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
	 * @param bool $refresh
	 * @return RestToken|NULL
	 */
	public function getRestToken($token, $refresh = TRUE)
	{
		$restToken = $this->restTokenRepository->getByToken($token);
		if ($restToken) {
			return $refresh ? $this->restTokenRepository->refreshToken($restToken) : $restToken;
		} else {
			return NULL;
		}
	}


	/**
	 * @param Wall $wall
	 * @param User $user
	 * @param string $ip
	 * @return RestToken
	 */
	public function getOrGenerateRestToken(Wall $wall, User $user, $ip)
	{
		if ($restToken = $this->restTokenRepository->getRestTokenByUser($wall, $user, $ip)) {
			return $this->restTokenRepository->refreshToken($restToken);
		} else {
			return $this->restTokenRepository->createRestToken($wall, $user, $ip);
		}
	}

}
