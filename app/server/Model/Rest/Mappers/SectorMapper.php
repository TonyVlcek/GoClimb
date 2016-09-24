<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\Line;
use GoClimb\Model\Entities\Sector;


class SectorMapper
{

	/**
	 * @param Sector[] $sectors
	 * @return array
	 */
	public static function mapArray(array $sectors)
	{
		$result = [];
		foreach ($sectors as $sector) {
			$result[$sector->getId()] = self::map($sector);
		}
		return $result;
	}


	/**
	 * @param Sector $sector
	 * @return array
	 */
	public static function map(Sector $sector)
	{
		return [
			'id' => $sector->getId(),
			'name' => $sector->getName(),
			'lines' => array_map(function (Line $line) {
				return LineMapper::map($line);
			}, $sector->getLines()),
		];
	}

}
