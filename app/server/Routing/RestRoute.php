<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Routing;

use Nette\Application\Request;
use Nette\Application\Routers\Route;
use Nette\Http\IRequest;
use Nette\Http\Url;


class RestRoute extends Route
{

	public function match(IRequest $httpRequest)
	{
		if ($request = parent::match($httpRequest)) {
			$params = $request->getParameters();
			$params['action'] = strtolower($request->getMethod());
			$request->setParameters($params);
		}
		return $request;
	}


	public function constructUrl(Request $request, Url $url)
	{
		$request = clone $request;
		$params = $request->getParameters();
		if (isset($params['action'])) {
			$params['action'] = 'default';
		}
		$request->setParameters($params);
		return parent::constructUrl($request, $url);
	}

}
