<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Tests;

class Helpers
{

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
