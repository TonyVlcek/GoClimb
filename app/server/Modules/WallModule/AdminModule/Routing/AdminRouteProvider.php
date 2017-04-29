<?php
/**
 * @author Tomáš Blatný
 */
namespace GoClimb\Modules\WallModule\AdminModule\Routing;

use Nette\Application\IRouter;
use GoClimb\Routing\IRouterProvider;
use GoClimb\Routing\TranslatedRoute;


class AdminRouteProvider implements IRouterProvider
{

	/**
	 * @return IRouter[]
	 */
	public function getRoutes()
	{
		return [
			new TranslatedRoute('user-admin', [
				'module' => 'Admin',
				'presenter' => 'Dashboard',
				'action' => 'default',
			]),
		];
	}
}
