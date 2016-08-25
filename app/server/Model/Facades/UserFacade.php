<?php

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
	 * @param int $id
	 * @return User|NULL
	 */
	public function getById($id)
	{
		return $this->userRepository->getById($id);
	}


	/**
	 * @param string $email
	 * @param string $password
	 * @return User
	 * @throws UserException
	 */
	public function registerUser($email, $password)
	{
		$user = $this->userRepository->createUser($email, $password);

		return $user;
	}

}
