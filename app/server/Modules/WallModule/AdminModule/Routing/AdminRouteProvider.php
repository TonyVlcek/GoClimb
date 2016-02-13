<?php
/**
 * @author Tomáš Blatný
 */
namespace GoClimb\Modules\WallModule\AdminModule\Routing;

use GoClimb\Routing\TranslatedRoute;
use Nette\Application\IRouter;
use GoClimb\Routing\IRouterProvider;


class AdminRouteProvider implements IRouterProvider
{

	/**
	 * @return IRouter[]
	 */
	public function getRoutes()
	{
		return [
			new TranslatedRoute('admin', [
				'module' => 'Admin',
				'presenter' => 'Dashboard',
				'action' => 'default',
			]),
		];
	}
}
