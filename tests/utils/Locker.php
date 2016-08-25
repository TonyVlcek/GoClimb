<?php

namespace GoClimb\Tests\Utils;

use Tester\Environment;


class Locker
{

	const DATABASE = 'database';

	public static $path;


	public static function lock($name)
	{
		Environment::lock($name, self::$path);
	}
}
