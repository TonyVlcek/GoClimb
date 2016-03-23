<?php

namespace GoClimb\Model\Enums;


class Resource
{

	const BACKEND_DASHBOARD = 'backend_dashboard';


	public static function isValid($resource)
	{
		return in_array($resource, self::getAll(), TRUE);
	}


	public static function getAll()
	{
		return self::getBackend();
	}


	public static function getBackend()
	{
		return [
			self::BACKEND_DASHBOARD,
		];
	}

}
