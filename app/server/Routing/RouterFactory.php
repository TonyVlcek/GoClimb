<?php

namespace GoClimb\Routing;

use GoClimb\Model\Repositories\WallRepository;
use GoClimb\Routing\Filters\BackendFilter;
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

	/** @var BackendFilter */
	private $backendFilter;



	public function __construct($useVirtualHosts, $useHttps, $domains, WallRepository $wallRepository)
	{
		$this->useVirtualHosts = $useVirtualHosts;
		$this->useHttps = $useHttps;
		$this->domains = $this->buildDomains($domains);
		$this->wallRepository = $wallRepository;
	}


	public function injectFilters(BackendFilter $backendFilter)
	{
		$this->backendFilter = $backendFilter;
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
		$router = new RouteList;

		if (PHP_SAPI === 'cli') {
			return $router; // to prevent failures from database queries before migrations
		}

		foreach ($this->wallRepository->getAll() as $wall) {
			foreach ($wall->getWallLanguages() as $wallLanguage) {
				$filter = [Route::FILTER_OUT => function (array $params) use ($wallLanguage) {
					return (isset($params['wall']) && $wallLanguage->getWall() === $params['wall']) ? $params : NULL;
				}];

				$router[] = new Route('//' . rtrim($wallLanguage->getUrl(), '/') . '/api/<presenter>/<action>[/<id>]', [
					'module' => 'Wall:Rest',
					'presenter' => 'Dashboard',
					'action' => 'default',
					'wall' => $wall,
					'locale' => $wallLanguage->getLanguage()->getShortcut(),
					NULL => $filter,
				]);
				$router[] = new Route('//' .rtrim($wallLanguage->getUrl(), '/') . '/admin[/<path .*>]', [
					'module' => 'Wall:Admin',
					'presenter' => 'Dashboard',
					'action' => 'default',
					'path' => [
						Route::VALUE => '',
						Route::FILTER_OUT => NULL,
						Route::FILTER_IN => NULL,
					],
					'wall' => $wall,
					'locale' => $wallLanguage->getLanguage()->getShortcut(),
					NULL => $filter,
				]);
				$router[] = new Route('//' .rtrim($wallLanguage->getUrl(), '/') . '[/<path .*>]', [
					'module' => 'Wall:Front',
					'presenter' => 'Dashboard',
					'action' => 'default',
					'path' => [
						Route::VALUE => '',
						Route::FILTER_OUT => NULL,
						Route::FILTER_IN => NULL,
					],
					'wall' => $wall,
					'locale' => $wallLanguage->getLanguage()->getShortcut(),
					NULL => $filter,
				]);
			}
		}

		return $router;
	}


	private function createAuthRoutes()
	{
		$router = new RouteList('Auth');

		$this->addRoute($router, 'auth', '<token>/<action login|logout>', [
			'presenter' => 'Dashboard',
		]);

		return $router;
	}


	private function createAdminRoutes()
	{
		$router = new RouteList('Backend');

		$this->addRoute($router, 'admin', '<presenter>/<action>[/<id>]', [
			'presenter' => 'Dashboard',
			'action' => 'default',
			NULL => $this->backendFilter->getFilterDefinition(),
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
