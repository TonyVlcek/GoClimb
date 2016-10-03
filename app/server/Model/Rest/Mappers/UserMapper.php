<?php

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\User;


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
			'name' => $user->getDisplayedName(),
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
		];
	}

}
