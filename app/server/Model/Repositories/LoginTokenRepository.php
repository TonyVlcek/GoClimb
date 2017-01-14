<?php

namespace GoClimb\Model\Repositories;

use Nette\Utils\DateTime;
use Nette\Utils\Random;
use GoClimb\Model\Entities\LoginToken;
use GoClimb\Model\Entities\User;


class LoginTokenRepository extends BaseRepository
{

	/**
	 * @param User $user
	 * @param DateTime $expiration
	 * @return LoginToken|NULL
	 */
	public function getByUser(User $user, $expiration = NULL)
	{
		if (!$expiration){
			$expiration = new DateTime;
		}

		return $this->getDoctrineRepository()->findOneBy(['user' => $user, 'expiration >=' => $expiration ]);
	}


	/**
	 * @param string $token
	 * @param DateTime $expiration
	 * @return LoginToken|NULL
	 */
	public function getByToken($token, $expiration = NULL)
	{
		if (!$expiration){
			$expiration = new DateTime;
		}
		return $this->getDoctrineRepository()->findOneBy(['token' => $token, 'expiration >=' => $expiration]);
	}


	/**
	 * @param User $user
	 * @param DateTime $expiration
	 * @param bool $longTerm
	 * @return LoginToken
	 */
	public function createLoginToken(User $user, $expiration, $longTerm)
	{
		$token = new LoginToken;
		$token->setUser($user);
		$user->addLoginToken($token);
		$token->setToken($this->generateRandomToken());
		$token->setExpiration($expiration);
		$token->setLongTerm($longTerm);
		$this->getEntityManager()
			->persist($token)
			->flush();
		return $token;
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
