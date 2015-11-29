<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Modules\AuthModule\Routing;

use Nette\Application\IRouter;
use OnlineClimbing\Routing\IRouterProvider;
use OnlineClimbing\Routing\TranslatedRoute;


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
