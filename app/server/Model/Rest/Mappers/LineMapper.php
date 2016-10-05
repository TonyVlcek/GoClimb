<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\Line;


class LineMapper
{

	/**
	 * @param Line[] $lines
	 * @return array
	 */
	public static function mapArray(array $lines)
	{
		$result = [];
		foreach ($lines as $line) {
			$result[$line->getId()] = self::map($line);
		}
		return $result;
	}


	/**
	 * @param Line $line
	 * @return array
	 */
	public static function map(Line $line)
	{
		return [
			'id' => $line->getId(),
			'name' => $line->getName(),
		];
	}

}
