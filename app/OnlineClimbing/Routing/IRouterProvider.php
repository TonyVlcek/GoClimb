<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\Routing;

use Nette\Application\IRouter;


interface IRouterProvider
{

	/**
	 * @return IRouter[]
	 */
	function getRoutes();

}
