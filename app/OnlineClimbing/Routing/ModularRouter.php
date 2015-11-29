<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Routing;

use Nette\Application\Routers\RouteList;


class ModularRouter extends RouteList
{

	/**
	 * @param string $module
	 * @param IRouterProvider $routerProvider
	 * @return $this
	 */
	public function addRouterProvider($module, IRouterProvider $routerProvider)
	{
		$this[] = $router = new RouteList($module);
		foreach ($routerProvider->getRoutes() as $route) {
			$router[] = $route;
		}
		return $this;
	}

}
