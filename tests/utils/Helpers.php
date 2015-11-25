<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Tests;

use Nette\DI\Container;


class Helpers
{

	/** @var Container */
	public static $container;


	public static function runTestCase($className)
	{
		$testCase = self::$container->createInstance($className);
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
