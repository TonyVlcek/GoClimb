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
		return array_map(function ($entity) {
			return $entity->getId();
		}, $entities);
	}

}
