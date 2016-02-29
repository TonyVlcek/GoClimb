<?php

namespace GoClimb\Model\Repositories;

use Nette\Security\Passwords;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Entities\Wall;
use GoClimb\Model\UserException;


class UserRepository extends BaseRepository
{

	/**
	 * @param int $id
	 * @return User|NULL
	 */
	public function getById($id)
	{
		return $this->getDoctrineRepository()->find($id);
	}


	/**
	 * @param string $name
	 * @return User|NULL
	 */
	public function getByName($name)
	{
		return $this->getDoctrineRepository()->findOneBy(['name' => $name]);
	}

	/**
	 * @param string $email
	 * @return User|NULL
	 */
	public function getByEmail($email)
	{
		return $this->getDoctrineRepository()->findOneBy(['email' => $email]);
	}


	/**
	 * @param string $email
	 * @param string $password
	 * @return User
	 * @throws UserException
	 */
	public function createUser($email, $password)
	{
		if ($this->getByEmail($email)) {
			throw UserException::duplicateEmail($email);
		}

		$user = new User;
		$user->setEmail($email)
			->setPassword(Passwords::hash($password));

		$this->getEntityManager()
			->persist($user)
			->flush($user);

		return $user;
	}


	/**
	 * @param User $user
	 * @param Wall $wall
	 * @return $this
	 */
	public function addFavoriteWall(User $user, Wall $wall)
	{
		$user->addFavoriteWall($wall);
		$wall->addUserFavorite($user);

		$this->getEntityManager()
			->persist([$user, $wall])
			->flush([$user, $wall]);

		return $this;
	}


	/**
	 * @param User $user
	 * @param Wall $wall
	 * @return $this
	 */
	public function removeFavoriteWall(User $user, Wall $wall)
	{
		$user->removeFavoriteWall($wall);
		$wall->removeUserFavorite($user);

		$this->getEntityManager()
			->persist([$user, $wall])
			->flush([$user, $wall]);

		return $this;
	}
}
