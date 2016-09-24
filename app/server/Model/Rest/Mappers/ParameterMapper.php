<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\Parameter;


class ParameterMapper
{

	/**
	 * @param array $parameters
	 * @return array
	 */
	public static function mapArray(array $parameters)
	{
		$result = [];
		foreach ($parameters as $parameter) {
			$result[] = self::map($parameter);
		}
		return $result;
	}


	/**
	 * @param Parameter $parameter
	 * @return array
	 */
	public static function map(Parameter $parameter)
	{
		return [
			'id' => $parameter->getId(),
			'name' => $parameter->getName(),
		];
	}

}
