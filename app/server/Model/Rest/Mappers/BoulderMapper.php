<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\Boulder;


class BoulderMapper
{


	/**
	 * @param Boulder[] $boulders
	 * @return array
	 */
	public static function mapArray(array $boulders)
	{
		$result = [];
		foreach ($boulders as $boulder) {
			$result[$boulder->getId()] = self::map($boulder);
		}
		return $result;
	}


	/**
	 * @param Boulder $boulder
	 * @return array
	 */
	public static function map(Boulder $boulder)
	{
		$result = RouteMapper::map($boulder);
		$result['ratings'] = RatingMapper::mapArray($boulder->getRatings());
		$result['start'] = $boulder->getStart();
		$result['end'] = $boulder->getEnd();
		return $result;
	}

}
