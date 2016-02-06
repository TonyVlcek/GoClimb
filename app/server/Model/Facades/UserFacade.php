<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Facades;

use GoClimb\Model\Entities\User;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\UserException;
use Nette\Utils\Validators;


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
