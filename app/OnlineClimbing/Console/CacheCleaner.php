<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Console;

use Nette\Utils\Strings;


class CacheCleaner
{

	public static $cachePaths = [
		__DIR__ . '/../../../temp',
		__DIR__ . '/../../../tests/temp',
	];


	public static function cleanCache()
	{
		$result = [];
		foreach (self::$cachePaths as $cachePath) {
			$path = self::normalizePath($cachePath);
			$result[$path] = DirectoryCleaner::clean($path);
		}
		return $result;
	}


	private static function normalizePath($path)
	{
		while (strpos($path, '/../') !== FALSE) {
			$path = Strings::replace($path, '~[a-zA-Z0-9]+/\\.\\./~', '');
		}
		return $path;
	}

}
