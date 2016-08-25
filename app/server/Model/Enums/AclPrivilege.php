<?php

namespace GoClimb\Model\Enums;


class AclPrivilege
{

	const READ = 'read';
	const WRITE = 'write';


	public static function isValid($privilege)
	{
		return in_array($privilege, self::getAll(), TRUE);
	}


	public static function getAll()
	{
		return [
			self::READ,
			self::WRITE,
		];
	}

}
