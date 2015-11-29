<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Modules\BackendModule\Routing;

use Nette\Application\IRouter;
use OnlineClimbing\Routing\IRouterProvider;
use OnlineClimbing\Routing\TranslatedRoute;


class BackendRouteProvider implements IRouterProvider
{

	/**
	 * @return IRouter[]
	 */
	public function getRoutes()
	{
		return [
			new TranslatedRoute('admin/<presenter>/<action>', [
				'presenter' => 'Dashboard',
				'action' => 'default',
			]),
		];
	}
}
