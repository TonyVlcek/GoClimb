<?php

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\RestToken;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use Nette\Utils\DateTime;
use Nette\Utils\Random;


class RestTokenRepository extends BaseRepository
{

	/**
	 * @param Wall $wall
	 * @param User $user
	 * @param string $ip
	 * @return RestToken|NULL
	 */
	public function getRestTokenByUser(Wall $wall, User $user, $ip)
	{
		return $this->getDoctrineRepository()->findOneBy([
			'wall' => $wall,
			'user' => $user,
			'remoteIp' => $ip,
			'expiration >=' => new DateTime,
		]);
	}


	/**
	 * @param User $user
	 * @param string $ip
	 * @return RestToken|NULL
	 */
	public function getGlobalRestTokenByUser(User $user, $ip)
	{
		return $this->getDoctrineRepository()->findOneBy([
			'wall' => NULL,
			'user' => $user,
			'remoteIp' => $ip,
			'expiration >=' => new DateTime(),
		]);
	}


	/**
	 * @param string $token
	 * @return RestToken|NULL
	 */
	public function getByToken($token)
	{
		return $this->getDoctrineRepository()->findOneBy(['token' => $token]);
	}


	/**
	 * @param Wall $wall
	 * @param User $user
	 * @param string $ip
	 * @return RestToken
	 */
	public function createRestToken(Wall $wall, User $user, $ip)
	{
		$restToken = new RestToken;

		$restToken->setUser($user);
		$user->addRestToken($restToken);

		$restToken->setWall($wall);
		$wall->addRestToken($restToken);

		$restToken->setRemoteIp($ip);
		$restToken->setToken($this->generateRandomToken());

		return $this->refreshToken($restToken);
	}


	/**
	 * @param User $user
	 * @param string $ip
	 * @return RestToken
	 */
	public function createGlobalRestToken(User $user, $ip)
	{
		$restToken = new RestToken;

		$restToken->setUser($user);
		$user->addRestToken($restToken);

		$restToken->setRemoteIp($ip);
		$restToken->setToken($this->generateRandomToken());

		return $this->refreshToken($restToken);
	}


	public function refreshToken(RestToken $restToken)
	{
		$restToken->setExpiration(DateTime::from('+4 hours'));
		$this->getEntityManager()
			->persist($restToken)
			->flush();
		return $restToken;
	}


	/**
	 * @return string
	 */
	private function generateRandomToken()
	{
		do {
			$token = Random::generate(32);
		} while ($this->getByToken($token));

		return $token;
	}

}
