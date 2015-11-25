<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Tests;

use Nette\DI\Container;
use OnlineClimbing\Tests\Utils\TestCase;


class Helpers
{

	/** @var Container */
	public static $container;


	public static function runTestCase($className)
	{
		$testCase = self::$container->createInstance($className);
		if ($testCase instanceof TestCase) {
			self::$container->callInjects($testCase);
		}
		$testCase->run();
	}


	/**
	 * Returns IDs of given entities
	 *
	 * @param array $entities
	 * @return int[]
	 */
	public static function mapIds(array $entities)
	{
		$ids = array_values(array_map(function ($entity) {
			return $entity->getId();
		}, $entities));
		sort($ids);
		return $ids;
	}
}
