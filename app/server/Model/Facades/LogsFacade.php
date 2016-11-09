<?php

namespace GoClimb\Model\Facades;

use GoClimb\Model\Entities\Log;
use GoClimb\Model\Repositories\UserRepository;


class LogsFacade
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
	 * @return Log[]
	 */
	public function getLogsByUserId($id)
	{
		return $this->userRepository->getById($id)->getLogs();
	}
}
