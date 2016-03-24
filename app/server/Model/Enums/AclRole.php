<?php

namespace GoClimb\Model\Enums;


class AclRole
{

	const GUEST = 'guest';
	const OWNER = 'owner';


	public static function isValid($role)
	{
		return in_array($role, self::getAll(), TRUE);
	}


	public static function getAll()
	{
		return [
			self::GUEST,
			self::OWNER,
		];
	}

}
