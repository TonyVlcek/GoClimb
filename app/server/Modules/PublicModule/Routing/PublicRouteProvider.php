<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\PublicModule\Routing;

use Nette\Application\IRouter;
use GoClimb\Routing\IRouterProvider;
use GoClimb\Routing\TranslatedRoute;


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
