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
		$path = str_replace('/', DIRECTORY_SEPARATOR, $path);
		while (strpos($path, DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR) !== FALSE) {
			$path = Strings::replace($path, '~[a-zA-Z0-9]+' . DIRECTORY_SEPARATOR . '\\.\\.' . DIRECTORY_SEPARATOR . '~', '');
		}
		return $path;
	}

}
