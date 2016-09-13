<?php

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\AclRole;


class RoleMapper
{

	/**
	 * @param array $roles
	 * @return array
	 */
	public static function mapArray(array $roles)
	{
		$result = [];
		foreach ($roles as $role) {
			$result[$role->getId()] = self::map($role);
		}

		return $result;
	}


	/**
	 * @param AclRole $role
	 * @return array
	 */
	public static function map(AclRole $role)
	{
		$parent = $role->getParent();
		$users = self::mapRolesUsers($role);

		return [
			'id' => $role->getId(),
			'name' => $role->getName(),
			'parent' => $parent ? $parent->getId() : NULL,
			'users' => $users,
		];
	}


	/**
	 * @param AclRole $role
	 * @return array
	 */
	public static function mapRolesUsers(AclRole $role)
	{
		$users = [];
		foreach ($role->getUsers() as $user) {
			$users[] = UserMapper::mapBasicInfo($user);
		}
		return $users;
	}

}
