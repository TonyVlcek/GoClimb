<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Repositories;

use Nette\Security\Passwords;
use OnlineClimbing\Model\Entities\User;
use OnlineClimbing\Model\UserException;


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
	 * @param string $name
	 * @param string $password
	 * @return User
	 * @throws UserException
	 */
	public function createUser($name, $password)
	{
		if ($this->getByName($name)) {
			throw UserException::duplicateName($name);
		}

		$user = new User;
		$user->setName($name)
			->setPassword(Passwords::hash($password));

		$this->getEntityManager()
			->persist($user)
			->flush($user);

		return $user;
	}


	/**
	 * @return string
	 */
	protected function getEntityClass()
	{
		return User::class;
	}

}
