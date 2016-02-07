<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Routing;

use Nette\Application\IRouter;


interface IRouterProvider
{

	/**
	 * @return IRouter[]
	 */
	function getRoutes();

}
