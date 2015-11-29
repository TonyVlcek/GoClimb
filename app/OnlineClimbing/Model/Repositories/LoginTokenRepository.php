<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Repositories;

use Nette\Utils\DateTime;
use Nette\Utils\Random;
use OnlineClimbing\Model\Entities\LoginToken;
use OnlineClimbing\Model\Entities\User;


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
	 * @return LoginToken
	 */
	public function createLoginToken(User $user)
	{
		$token = new LoginToken;
		$token->setUser($user);
		$user->addLoginToken($token);
		$token->setToken($this->generateRandomToken());
		$token->setExpiration(DateTime::from('+1 minute'));
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
