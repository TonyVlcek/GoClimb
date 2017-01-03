<?php

namespace GoClimb\Model\Rest\Updaters;

use GoClimb\Model\Entities\User;
use GoClimb\Model\MappingException;
use GoClimb\Model\Repositories\UserRepository;
use GoClimb\Model\Rest\Utils;
use Nette\Utils\DateTime;
use stdClass;


class UserUpdater
{

	/** @var UserUpdater */
	private $userRepository;


	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}


	/**
	 * @param User $user
	 * @param stdClass $data
	 * @throws MappingException
	 * @return User
	 */
	public function updateUser(User $user, stdClass $data = NULL)
	{
		if (!$data) {
			throw MappingException::invalidData();
		}

		Utils::updateProperties($user, $data, [
			'nick' => FALSE,
			'firstName' => FALSE,
			'lastName' => FALSE,
			'height' => FALSE,
			'weight' => FALSE,
			'phone' => FALSE,
		]);

		if ($data->climbingSince) {
			$user->setClimbingSince(new DateTime($data->climbingSince));
		} else {
			$user->setClimbingSince(NULL);
		}

		if ($data->birthDate) {
			$user->setBirthDate(new DateTime($data->birthDate));
		} else {
			$user->setBirthDate(NULL);
		}

		$this->userRepository->save($user);

		return $user;
	}

}
