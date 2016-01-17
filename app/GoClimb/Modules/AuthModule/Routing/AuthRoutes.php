<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Modules\AuthModule\Routing;

use Nette\Application\IRouter;
use GoClimb\Routing\IRouterProvider;
use GoClimb\Routing\TranslatedRoute;


class AuthRoutes implements IRouterProvider
{

	/**
	 * @return IRouter[]
	 */
	public function getRoutes()
	{
		return [
			new TranslatedRoute('auth/<action login|logout>[/<token>]', [
				'presenter' => 'Dashboard',
			]),
		];
	}

}
