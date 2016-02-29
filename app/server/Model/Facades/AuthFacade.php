<?php

namespace GoClimb\Model\Facades;

use GoClimb\Model\Entities\Application;
use GoClimb\Model\Entities\LoginToken;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Repositories\ApplicationRepository;
use GoClimb\Model\Repositories\LoginTokenRepository;


class AuthFacade
{

	/** @var ApplicationRepository */
	private $applicationRepository;

	/** @var LoginTokenRepository */
	private $loginTokenRepository;


	public function __construct(ApplicationRepository $applicationRepository, LoginTokenRepository $loginTokenRepository)
	{
		$this->applicationRepository = $applicationRepository;
		$this->loginTokenRepository = $loginTokenRepository;
	}


	/**
	 * @param string $token
	 * @return Application|NULL
	 */
	public function getApplicationByToken($token)
	{
		return $this->applicationRepository->getByToken($token);
	}


	/**
	 * @param User $user
	 * @return LoginToken
	 */
	public function getLoginTokenForUser(User $user)
	{
		if ($token = $this->loginTokenRepository->getByUser($user)) {
			return $token;
		}
		return $this->loginTokenRepository->createLoginToken($user);
	}


	/**
	 * @param string $token
	 * @return User|NULL
	 */
	public function getUserByToken($token)
	{
		if ($token = $this->loginTokenRepository->getByToken($token)) {
			return $token->getUser();
		}
		return NULL;
	}

}
