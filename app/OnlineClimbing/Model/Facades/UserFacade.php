<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Model\Facades;

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
