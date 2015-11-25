<?php
/**
 * Test: RouteRepository test
 *
 * @author Tony Vlček
 */

use Nette\DI\Container;
use OnlineClimbing\Model\Repositories\RouteRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


/** @var Container $container */
$container = require __DIR__ . "/../../bootstrap.php";

class RouteRepositoryTestCase extends DatabaseTestCase
{

	public function testGetById()
	{
		/** @var RouteRepository $routeRepository */
		$routeRepository = $this->container->getByType(RouteRepository::class);

		Assert::truthy($route = $routeRepository->getById(1));
		Assert::equal(1, $route->getId());
		Assert::equal(1, $route->getLine()->getId());

	}
}

testCase(new RouteRepositoryTestCase($container));
