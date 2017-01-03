<?php

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\User;
use GoClimb\Model\Rest\Utils;


class UserMapper
{

	/**
	 * @param User[] $users
	 * @return array
	 */
	public static function mapArray($users)
	{
		$result = [];
		foreach ($users as $key => $user) {
			$result[$key] = self::map($user);
		}

		return $result;

	}


	/**
	 * @param User $user
	 * @return array
	 */
	public static function map(User $user)
	{
		return [
			'id' => $user->getId(),
			'email' => $user->getEmail(),
			'name' => $user->getDisplayedName(),
			'weight' => $user->getWeight(),
			'height' => $user->getHeight(),
			'phone' => $user->getPhone(),
			'climbingSince' => Utils::formatDateTime($user->getClimbingSince()),
			'birthDate' => Utils::formatDateTime($user->getBirthDate()),
			'firstName' => $user->getFirstName(),
			'lastName' => $user->getLastName(),
			'nick' => $user->getNick(),
		];
	}


	/**
	 * @param User $user
	 * @return array
	 */
	public static function mapBasicInfo(User $user)
	{
		return [
			'id' => $user->getId(),
			'name' => $user->getDisplayedName(),
			'email' => $user->getEmail(),
			'basic' => true,
		];
	}

}
