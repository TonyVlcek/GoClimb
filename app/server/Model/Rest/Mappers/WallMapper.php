<?php

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\Wall;


class WallMapper
{

	/**
	 * @param Wall $wall
	 * @return array
	 */
	public static function mapDetails(Wall $wall)
	{
		return [
			'name' => $wall->getName(),
			'description' => $wall->getDescriptions(),
			'street' => $wall->getStreet(),
			'number' => $wall->getNumber(),
			'country' => $wall->getCountry(),
			'zip' => $wall->getZip(),
		];
	}


	public static function mapBasicInfo(Wall $wall)
	{
		return [
			'name' => $wall->getName(),
		];
	}

}
