<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\Difficulty;


class DifficultyMapper
{


	/**
	 * @param Difficulty[] $difficulties
	 * @return array
	 */
	public static function mapArray(array $difficulties)
	{
		return array_map(function (Difficulty $difficulty) {
			return self::map($difficulty);
		}, $difficulties);
	}


	/**
	 * @param Difficulty $difficulty
	 * @return array
	 */
	public static function map(Difficulty $difficulty)
	{
		return [
			'id' => $difficulty->getId(),
			'UIAA' => $difficulty->getRatingUIAA(),
			'FRL' => $difficulty->getRatingFRL(),
			'HUECO' => $difficulty->getRatingHUECO(),
			'FRB' => $difficulty->getRatingFRB(),
			'points' => $difficulty->getPoints(),
		];
	}

}
