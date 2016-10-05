<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Rest\Mappers;

use GoClimb\Model\Entities\Color;
use GoClimb\Model\Entities\Route;
use GoClimb\Model\Entities\RouteParameter;
use GoClimb\Model\Rest\Utils;


class RouteMapper
{

	public static function map(Route $route)
	{
		return [
			'id' => $route->getId(),
			'name' => $route->getName(),
			'description' => $route->getDescription(),
			'dateCreated' => Utils::formatDateTime($route->getDateCreated()),
			'dateRemoved' => Utils::formatDateTime($route->getDateRemoved()),
			'builder' => [
				'id' => $route->getBuilder()->getId(),
				'name' => $route->getBuilder()->getDisplayedName(),
			],
			'line' => [
				'id' => $route->getLine()->getId(),
				'name' => $route->getLine()->getName(),
			],
			'sector' => [
				'id' => $route->getLine()->getSector()->getId(),
				'name' => $route->getLine()->getSector()->getName(),
			],
			'colors' => self::mapColors($route->getColors()),
			'difficulty' => DifficultyMapper::map($route->getDifficulty()),
			'parameters' => self::mapParameters($route->getRouteParameters()),
		];
	}


	/**
	 * @param Color[] $colors
	 * @return array
	 */
	private static function mapColors(array $colors)
	{
		$result = [];
		foreach ($colors as $color) {
			$result[] = $color->getHash();
		}
		return $result;
	}


	/**
	 * @param RouteParameter[] $routeParameters
	 * @return array
	 */
	private static function mapParameters(array $routeParameters)
	{
		$result = [];
		foreach ($routeParameters as $routeParameter) {
			$result[] = [
				'parameter' => $routeParameter->getParameter()->getName(),
				'level' => $routeParameter->getLevel(),
			];
		}
		return $result;
	}

}
