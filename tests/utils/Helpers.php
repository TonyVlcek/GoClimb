<?php

namespace GoClimb\Tests;

use Nette\DI\Container;
use GoClimb\Tests\Utils\TestCase;
use Tester\Assert;


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


	public static function assertTypeRecursive($type, array $array)
	{
		foreach ($array as $item) {
			Assert::type($type, $item);
		}
	}
}
