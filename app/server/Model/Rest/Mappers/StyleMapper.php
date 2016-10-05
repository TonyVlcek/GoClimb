<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\Style;


class StyleMapper
{

	/**
	 * @param Style[] $styles
	 * @return array
	 */
	public static function mapArray(array $styles)
	{
		$result = [];
		foreach ($styles as $style) {
			$result[$style->getId()] = self::map($style);
		}

		return $result;
	}


	/**
	 * @param Style $style
	 * @return array
	 */
	public static function map(Style $style)
	{
		return [
			'id' => $style->getId(),
			'name' => $style->getName(),
			'ropePoints' => $style->getRopePoints(),
			'boulderPoints' => $style->getBoulderPoints(),
		];
	}

}
