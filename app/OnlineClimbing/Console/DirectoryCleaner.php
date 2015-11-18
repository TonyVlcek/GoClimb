<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Console;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;


class DirectoryCleaner
{

	public static function clean($dir, &$result = NULL)
	{
		$blackList = ['.', '..', '.gitignore'];
		$result = ($result !== NULL) ? $result : [
			'dirsToRemove' => 0,
			'dirsRemoved' => 0,
			'filesToRemove' => 0,
			'filesRemoved' => 0,
		];

		foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $fileName => $fileInfo) {
			/** @var $fileInfo SplFileInfo */
			if (!in_array($fileInfo->getFilename(), $blackList, TRUE)) {
				if (is_dir($fileName)) {
					$result['dirsToRemove']++;
					self::clean($fileName, $result);
					@rmdir($fileName);
					if (!is_dir($fileName)) {
						$result['dirsRemoved']++;
					}
				} elseif (is_file($fileName)) {
					$result['filesToRemove']++;
					@unlink($fileName);
					if (!is_file($fileName)) {
						$result['filesRemoved']++;
					}
				}
			}
		}
		return $result;
	}

}
