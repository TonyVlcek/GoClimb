<?php

namespace GoClimb\Model\Enums;


class AclRole
{

	const GUEST = 'guest';

	const GOCLIMB_SUPPORT = 'goclimb.support';
	const GOCLIMB_ADMIN = 'goclimb.administrator';
	const GOCLIMB_OWNER = 'goclimb.owner';

	const WALL_BUILDER = 'wall.builder';
	const WALL_ADMIN = 'wall.admin';
	const WALL_OWNER = 'wall.owner';


	/** @deprecated */
	const OLD_OWNER = 'owner';


	public static function isValid($role)
	{
		return in_array($role, self::getAll(), TRUE);
	}


	public static function getGlobal()
	{
		return [
			self::GUEST,
			self::GOCLIMB_SUPPORT,
			self::GOCLIMB_ADMIN,
			self::GOCLIMB_OWNER,
			self::OLD_OWNER,
		];
	}


	public static function getForWall()
	{
		return [
			self::WALL_BUILDER,
			self::WALL_ADMIN,
			self::WALL_OWNER,
		];
	}


	public static function getAll()
	{
		return array_merge(self::getGlobal(), self::getForWall());
	}

}
