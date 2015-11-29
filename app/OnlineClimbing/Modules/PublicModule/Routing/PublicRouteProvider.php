<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Modules\PublicModule\Routing;

use Nette\Application\IRouter;
use OnlineClimbing\Routing\IRouterProvider;
use OnlineClimbing\Routing\TranslatedRoute;


class PublicRouteProvider implements IRouterProvider
{

	/**
	 * @return IRouter[]
	 */
	public function getRoutes()
	{
		return [
			new TranslatedRoute('', [
				'presenter' => 'Dashboard',
				'action' => 'default',
			])
		];
	}
}
