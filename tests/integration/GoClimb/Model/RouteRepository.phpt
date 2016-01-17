<?php
/**
 * Test: RouteRepository test
 *
 * @author Tony Vlček
 */

use GoClimb\Model\Entities\Line;
use GoClimb\Model\Entities\Route;
use GoClimb\Model\Entities\User;
use GoClimb\Model\Repositories\RouteRepository;
use GoClimb\Tests\Utils\DatabaseTestCase;
use Tester\Assert;


require __DIR__ . "/../../../bootstrap.php";

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
		Assert::null($this->routeRepository->getById(0));
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
