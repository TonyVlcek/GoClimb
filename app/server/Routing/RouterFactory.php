<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Routing;

use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Modules\BackendModule\Routing\Filters\CompanyFilter;
use GoClimb\Modules\BackendModule\Routing\Filters\UserFilter;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


class RouterFactory
{

	/** @var bool */
	private $useVirtualHosts;

	/** @var bool */
	private $useHttps;

	/** @var array */
	private $domains;

	/** @var WallRepository */
	private $wallRepository;

	/** @var CompanyFilter */
	private $companyFilter;

	/** @var UserFilter */
	private $userFilter;


	public function __construct($useVirtualHosts, $useHttps, $domains, WallRepository $wallRepository)
	{
		$this->useVirtualHosts = $useVirtualHosts;
		$this->useHttps = $useHttps;
		$this->domains = $this->buildDomains($domains);
		$this->wallRepository = $wallRepository;
	}


	public function injectFilters(CompanyFilter $companyFilter, UserFilter $userFilter)
	{
		$this->companyFilter = $companyFilter;
		$this->userFilter = $userFilter;
	}


	/**
	 * @return RouteList
	 */
	public function create()
	{
		if ($this->useHttps) {
			Route::$defaultFlags = Route::SECURED;
		}

		$router = new RouteList;
		$router[] = $this->createWallRoutes();
		$router[] = $this->createAuthRoutes();
		$router[] = $this->createAdminRoutes();
		$router[] = $this->createPortalRoutes();
		return $router;
	}


	private function createWallRoutes()
	{
		$router = new RouteList('Wall');

		return $router;
	}


	private function createAuthRoutes()
	{
		$router = new RouteList('Auth');

		$this->addRoute($router, 'auth', '<action login|logout>[/<token>]', [
			'presenter' => 'Dashboard',
		]);

		return $router;
	}


	private function createAdminRoutes()
	{
		$router = new RouteList('Backend');

		$this->addRoute($router, 'admin', 'company/edit/<company>', [
			'presenter' => 'Company',
			'action' => 'edit',
			NULL => $this->companyFilter->getFilterDefinition(),
		]);

		$this->addRoute($router, 'admin', 'user/edit/<user>', [
			'presenter' => 'User',
			'action' => 'edit',
			NULL => $this->userFilter->getFilterDefinition(),
		]);

		$this->addRoute($router, 'admin', '<presenter>/<action>', [
			'presenter' => 'Dashboard',
			'action' => 'default',
		]);

		return $router;
	}


	private function createPortalRoutes()
	{
		$router = new RouteList('Public');

		$this->addRoute($router, '', '<presenter>/<action>[/<id>]', [
			'locale' => NULL,
			'presenter' => 'Dashboard',
			'action' => 'default',
			'id' => NULL,
		]);

		return $router;
	}


	private function addRoute(RouteList $routeList, $prefix, $route, $args = [])
	{
		if ($this->useVirtualHosts) {
			$prefix = $prefix ? $prefix . '.' : $prefix;
			foreach ($this->domains as $domain) {
				$routeList[] = new Route('//' . $prefix . $domain . '/' . $route, $args);
			}
		} else {
			$prefix = $prefix ? $prefix . '/' : $prefix;
			$routeList[] = new Route($prefix . '<locale>/' . $route, $args);
		}
	}


	private function buildDomains($domains)
	{
		$result = [];

		foreach ($domains as $domain => $languages) {
			$result[] = str_replace('<locale>', '<locale ' . implode('|', $languages). '>', $domain);
		}

		return $result;
	}

}
