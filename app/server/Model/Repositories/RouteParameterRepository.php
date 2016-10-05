<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Model\Repositories;

use GoClimb\Model\Entities\Parameter;
use GoClimb\Model\Entities\Route;
use GoClimb\Model\Entities\RouteParameter;


class RouteParameterRepository extends BaseRepository
{


	/**
	 * @param Route $route
	 * @param Parameter $parameter
	 * @param int $level
	 * @param bool $flush
	 * @return RouteParameter
	 */
	public function setRouteParameter(Route $route, Parameter $parameter, $level, $flush = FALSE)
	{
		foreach ($route->getRouteParameters() as $routeParameter) {
			if ($routeParameter->getParameter() === $parameter) {
				$this->save($routeParameter->setLevel($level), $flush);
				return $routeParameter;
			}
		}
		$routeParameter = new RouteParameter;
		$route->addRouteParameter($routeParameter->setRoute($route)->setParameter($parameter)->setLevel($level));
		return $routeParameter;
	}

}
