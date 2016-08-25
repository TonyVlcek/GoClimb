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
	 * @return LoginToken|NULL
	 */
	public function getByUser(User $user)
	{
		return $this->getDoctrineRepository()->findOneBy(['user' => $user, 'expiration >=' => new DateTime]);
	}


	/**
	 * @param string $token
	 * @return LoginToken|NULL
	 */
	public function getByToken($token)
	{
		return $this->getDoctrineRepository()->findOneBy(['token' => $token, 'expiration >=' => new DateTime]);
	}


	/**
	 * @param User $user
	 * @param bool $longTerm
	 * @return LoginToken
	 */
	public function createLoginToken(User $user, $longTerm)
	{
		$token = new LoginToken;
		$token->setUser($user);
		$user->addLoginToken($token);
		$token->setToken($this->generateRandomToken());
		$token->setExpiration(DateTime::from('+1 minute'));
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
