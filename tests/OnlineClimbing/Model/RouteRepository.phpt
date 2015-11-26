<?php
/**
 * Test: RouteRepository test
 *
 * @author Tony Vlček
 */

use OnlineClimbing\Model\Entities\Line;
use OnlineClimbing\Model\Entities\Route;
use OnlineClimbing\Model\Entities\User;
use OnlineClimbing\Model\Repositories\RouteRepository;
use OnlineClimbing\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../bootstrap.php";

class RouteRepositoryTestCase extends DatabaseTestCase
{

	/** @var RouteRepository */
	private $routeRepository;


	public function __construct(RouteRepository $routeRepository)
	{
		parent::__construct();
		$this->routeRepository = $routeRepository;
	}


	public function testGetById()
	{
		Assert::type(Route::class, $route = $this->routeRepository->getById(1));
		Assert::equal(1, $route->getId());
	}


	public function testMapping()
	{
		$route = $this->routeRepository->getById(1);
		Assert::type(Line::class, $line = $route->getLine());
		Assert::equal(1, $line->getId());

		Assert::type(User::class, $builder = $route->getBuilder());
		Assert::equal(1, $builder->getId());
	}
}

testCase(RouteRepositoryTestCase::class);
