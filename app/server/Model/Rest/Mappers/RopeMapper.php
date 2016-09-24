<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\Rope;


class RopeMapper
{


	/**
	 * @param Rope[] $ropes
	 * @return array
	 */
	public static function mapArray(array $ropes)
	{
		$result = [];
		foreach ($ropes as $rope) {
			$result[$rope->getId()] = self::map($rope);
		}
		return $result;
	}


	/**
	 * @param Rope $rope
	 * @return array
	 */
	public static function map(Rope $rope)
	{
		$result = RouteMapper::map($rope);
		$result['length'] = $rope->getLength();
		$result['steps'] = $rope->getSteps();
		return $result;
	}

}
