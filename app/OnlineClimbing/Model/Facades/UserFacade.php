<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Facades;

use Nette\Utils\Validators;
use OnlineClimbing\Model\Entities\User;
use OnlineClimbing\Model\Repositories\UserRepository;
use OnlineClimbing\Model\UserException;


class UserFacade
{

	/** @var UserRepository */
	private $userRepository;


	/**
	 * @param UserRepository $userRepository
	 */
	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}


	/**
	 * @param string $name
	 * @return User|NULL
	 */
	public function getByName($name)
	{
		Validators::assert($name, 'string');
		return $this->userRepository->getByName($name);
	}


	/**
	 * @param int $id
	 * @return User|NULL
	 */
	public function getById($id)
	{
		return $this->userRepository->getById($id);
	}


	/**
	 * @param string $name
	 * @param string $password
	 * @return User
	 * @throws UserException
	 */
	public function registerUser($name, $password)
	{
		$user = $this->userRepository->createUser($name, $password);

		return $user;
	}

}
