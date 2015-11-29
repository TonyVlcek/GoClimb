<?php

namespace OnlineClimbing;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


class RouterFactory
{

	/**
	 * TODO
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
		$router[] = new Route('[<locale [a-z]{2}>/]admin/<presenter>/<action>[/<id>]', [
			'locale' => NULL,
			'module' => 'Backend',
			'presenter' => 'Dashboard',
			'action' => 'default',
		]);
		$router[] = new Route('[<locale [a-z]{2}>/]<presenter>/<action>[/<id>]', [
			'locale' => NULL,
			'module' => 'Public',
			'presenter' => 'Dashboard',
			'action' => 'default',
		]);
		return $router;
	}

}
